<?php

namespace App\Http\Controllers;

use App\Models\Watch;
use App\Models\WatchFilter;
use App\Http\Requests\StoreWatchRequest;
use App\Http\Requests\UpdateWatchRequest;
use App\Services\ActivityLogService;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;

class WatchController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Watch::class);
        try {
            $query = Watch::query();

            // Apply search
            if (request('search')) {
                $query->search(request('search'));
            }

            // Apply filters
            if (request('status')) {
                $query->where('status', request('status'));
            }
            if (request('condition')) {
                $query->where('condition', request('condition'));
            }
            if (request('brand')) {
                $query->byBrand(request('brand'));
            }
            if (request('price_min')) {
                $query->where('asking_price', '>=', request('price_min'));
            }
            if (request('price_max')) {
                $query->where('asking_price', '<=', request('price_max'));
            }
            if (request('year_from')) {
                $query->where('year_produced', '>=', request('year_from'));
            }
            if (request('year_to')) {
                $query->where('year_produced', '<=', request('year_to'));
            }

            $watches = $query->latest()->paginate(15);
            $filters = auth()->user()->watchFilters;
            $conditions = ['mint', 'excellent', 'good', 'fair'];
            $statuses = ['available', 'sold', 'consigned', 'reserved'];
        } catch (Throwable $e) {
            report($e);
            $dbError = 'Database unavailable: please verify your database server and .env settings.';
            $watches = new LengthAwarePaginator([], 0, 15, request('page', 1), ['path' => request()->url(), 'query' => request()->query()]);
            $filters = [];
            $conditions = [];
            $statuses = [];
            return view('watches.index', compact('watches', 'filters', 'conditions', 'statuses'))->with('db_error', $dbError);
        }

        return view('watches.index', compact('watches', 'filters', 'conditions', 'statuses'));
    }

    public function create()
    {
        $this->authorize('create', Watch::class);
        return view('watches.create');
    }

    public function store(StoreWatchRequest $request)
    {
        $this->authorize('create', Watch::class);
        $watch = Watch::create($request->validated());
        ActivityLogService::logCreate($watch, 'New watch added: ' . $watch->brand . ' ' . $watch->model);
        return redirect()->route('watches.index')->with('success', 'Watch added successfully.');
    }

    public function show(Watch $watch)
    {
        $this->authorize('view', $watch);
        return view('watches.show', compact('watch'));
    }

    public function edit(Watch $watch)
    {
        $this->authorize('update', $watch);
        return view('watches.edit', compact('watch'));
    }

    public function update(UpdateWatchRequest $request, Watch $watch)
    {
        $this->authorize('update', $watch);
        $oldValues = $watch->getAttributes();
        $watch->update($request->validated());
        ActivityLogService::logUpdate($watch, $oldValues, 'Watch updated: ' . $watch->brand . ' ' . $watch->model);
        return redirect()->route('watches.index')->with('success', 'Watch updated successfully.');
    }

    public function destroy(Watch $watch)
    {
        $this->authorize('delete', $watch);
        ActivityLogService::logDelete($watch, 'Watch deleted: ' . $watch->brand . ' ' . $watch->model);
        $watch->delete();
        return redirect()->route('watches.index')->with('success', 'Watch deleted successfully.');
    }

    public function restore($id)
    {
        $this->authorize('delete', Watch::class);
        $watch = Watch::onlyTrashed()->findOrFail($id);
        ActivityLogService::logRestore($watch, 'Watch restored: ' . $watch->brand . ' ' . $watch->model);
        $watch->restore();
        return redirect()->route('watches.index')->with('success', 'Watch restored successfully.');
    }

    public function bulkAction()
    {
        $this->authorize('update', Watch::class);
        $watchIds = request('watch_ids', []);
        $action = request('action');

        if (empty($watchIds) || !in_array($action, ['sold', 'available', 'consigned', 'reserved', 'delete'])) {
            return back()->with('error', 'Invalid action or no watches selected.');
        }

        try {
            if ($action === 'delete') {
                Watch::whereIn('id', $watchIds)->delete();
                ActivityLogService::logBulkAction('Watch', $watchIds, 'delete', 'Bulk deleted ' . count($watchIds) . ' watches');
            } else {
                Watch::whereIn('id', $watchIds)->update(['status' => $action]);
                ActivityLogService::logBulkAction('Watch', $watchIds, 'status_update', 'Bulk updated status to ' . $action . ' for ' . count($watchIds) . ' watches');
            }

            return back()->with('success', 'Bulk action completed for ' . count($watchIds) . ' watches.');
        } catch (Throwable $e) {
            report($e);
            return back()->with('error', 'Error performing bulk action.');
        }
    }

    public function bulkPrice()
    {
        $this->authorize('update', Watch::class);
        $watchIds = request('watch_ids', []);
        $priceAdjustment = request('price_adjustment', 0);
        $priceType = request('price_type', 'fixed'); // 'fixed' or 'percentage'

        if (empty($watchIds)) {
            return back()->with('error', 'No watches selected.');
        }

        try {
            $watches = Watch::whereIn('id', $watchIds)->get();

            foreach ($watches as $watch) {
                $oldPrice = $watch->asking_price;
                if ($priceType === 'percentage') {
                    $watch->asking_price = $oldPrice + ($oldPrice * ($priceAdjustment / 100));
                } else {
                    $watch->asking_price = $oldPrice + $priceAdjustment;
                }
                $watch->save();
                ActivityLogService::logUpdate($watch, ['asking_price' => $oldPrice], 'Bulk price update: ' . $oldPrice . ' → ' . $watch->asking_price);
            }

            return back()->with('success', 'Bulk price update completed for ' . count($watchIds) . ' watches.');
        } catch (Throwable $e) {
            report($e);
            return back()->with('error', 'Error updating prices.');
        }
    }

    public function saveFilter()
    {
        $name = request('filter_name');
        $filters = [
            'search' => request('search'),
            'status' => request('status'),
            'condition' => request('condition'),
            'brand' => request('brand'),
            'price_min' => request('price_min'),
            'price_max' => request('price_max'),
            'year_from' => request('year_from'),
            'year_to' => request('year_to'),
        ];

        WatchFilter::updateOrCreate(
            ['user_id' => auth()->id(), 'name' => $name],
            ['filters' => $filters]
        );

        return back()->with('success', 'Filter "' . $name . '" saved successfully.');
    }

    public function applyFilter($filterId)
    {
        $filter = WatchFilter::findOrFail($filterId);
        $this->authorize('view', $filter);

        return redirect()->route('watches.index', $filter->filters);
    }
}
