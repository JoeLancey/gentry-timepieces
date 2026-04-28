<?php

namespace App\Http\Controllers;

use App\Models\Watch;
use App\Http\Requests\StoreWatchRequest;
use App\Http\Requests\UpdateWatchRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;

class WatchController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Watch::class);
        try {
            $watches = Watch::query()
                ->when(request('search'), fn($q) => $q->search(request('search')))
                ->when(request('status'), fn($q) => $q->where('status', request('status')))
                ->when(request('condition'), fn($q) => $q->where('condition', request('condition')))
                ->latest()
                ->paginate(15);
        } catch (Throwable $e) {
            report($e);
            $dbError = 'Database unavailable: please verify your database server and .env settings.';
            $watches = new LengthAwarePaginator([], 0, 15, request('page', 1), ['path' => request()->url(), 'query' => request()->query()]);
            return view('watches.index', compact('watches'))->with('db_error', $dbError);
        }

        return view('watches.index', compact('watches'));
    }

    public function create()
    {
        $this->authorize('create', Watch::class);
        return view('watches.create');
    }

    public function store(StoreWatchRequest $request)
    {
        $this->authorize('create', Watch::class);
        Watch::create($request->validated());
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
        $watch->update($request->validated());
        return redirect()->route('watches.index')->with('success', 'Watch updated successfully.');
    }

    public function destroy(Watch $watch)
    {
        $this->authorize('delete', $watch);
        $watch->delete();
        return redirect()->route('watches.index')->with('success', 'Watch deleted successfully.');
    }
}
