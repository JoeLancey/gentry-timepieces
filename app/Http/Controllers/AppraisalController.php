<?php
namespace App\Http\Controllers;
use App\Models\Appraisal;
use App\Models\ActivityLog;
use App\Models\Watch;
use App\Models\Client;
use App\Models\User;
use App\Http\Requests\StoreAppraisalRequest;
use App\Http\Requests\UpdateAppraisalRequest;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppraisalController extends Controller {
    public function index()
    {
        $appraisals = Appraisal::with(['watch', 'client', 'appraiser'])
            ->when(request('status'), function ($query, $status) {
                $query->where('workflow_status', $status);
            })
            ->when(request('search'), function ($query) {
                $search = request('search');

                $query->where(function ($subQuery) use ($search) {
                    $subQuery->whereHas('watch', function ($watchQuery) use ($search) {
                        $watchQuery->where('brand', 'like', "%{$search}%")
                            ->orWhere('model', 'like', "%{$search}%")
                            ->orWhere('serial_number', 'like', "%{$search}%");
                    })->orWhereHas('client', function ($clientQuery) use ($search) {
                        $clientQuery->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    })->orWhereHas('appraiser', function ($appraiserQuery) use ($search) {
                        $appraiserQuery->where('name', 'like', "%{$search}%");
                    });
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('appraisals.index', ['appraisals' => $appraisals]);
    }
    public function create() { return view('appraisals.create', ['clients'=>Client::all(), 'appraisers'=>User::where('role', 'staff')->orderBy('name')->get()]); }
    public function store(StoreAppraisalRequest $request) {
        DB::transaction(function () use ($request) {
            $watch = Watch::create([
                'brand' => $request->watch_brand,
                'model' => $request->watch_model,
                'reference_number' => $request->watch_reference_number,
                'serial_number' => $request->watch_serial_number,
                'year_produced' => $request->watch_year_produced,
                'condition' => $request->watch_condition,
                'has_box' => $request->boolean('watch_has_box'),
                'has_papers' => $request->boolean('watch_has_papers'),
                'asking_price' => 0,
                'cost_price' => 0,
                'status' => 'reserved',
                'description' => $request->watch_description,
            ]);

            $appraisal = Appraisal::create([
                'watch_id' => $watch->id,
                'client_id' => $request->client_id ?? null,
                'appraiser_id' => $request->appraiser_id,
                'appraised_value' => 0,
                'condition_notes' => 'Pending appraisal review.',
                'review_notes' => null,
                'has_box' => $request->boolean('has_box'),
                'has_papers' => $request->boolean('has_papers'),
                'status' => Appraisal::STATUS_PENDING,
            ]);

            ActivityLogService::logCreate($appraisal, 'Appraisal intake created for review.');
        });
        return redirect()->route('appraisals.index')->with('success','Appraisal saved.');
    }
    public function show(Appraisal $appraisal)
    {
        $timeline = ActivityLog::query()
            ->where('model_type', 'Appraisal')
            ->where('model_id', $appraisal->id)
            ->latest()
            ->get();

        return view('appraisals.show', compact('appraisal', 'timeline'));
    }
    public function edit(Appraisal $appraisal) { return view('appraisals.edit', ['appraisal'=>$appraisal,'clients'=>Client::orderBy('first_name')->orderBy('last_name')->get(),'appraisers'=>User::where('role', 'staff')->orderBy('name')->get()]); }
    public function update(UpdateAppraisalRequest $request, Appraisal $appraisal) {
        $oldValues = $appraisal->only(['appraised_value', 'condition_notes', 'review_notes', 'status']);

        DB::transaction(function () use ($request, $appraisal, $oldValues) {
            $appraisal->watch->update([
                'brand' => $request->watch_brand,
                'model' => $request->watch_model,
                'reference_number' => $request->watch_reference_number,
                'serial_number' => $request->watch_serial_number,
                'year_produced' => $request->watch_year_produced,
                'condition' => $request->watch_condition,
                'has_box' => $request->boolean('watch_has_box'),
                'has_papers' => $request->boolean('watch_has_papers'),
                'asking_price' => $request->status === Appraisal::STATUS_COMPLETED ? $request->appraised_value : $appraisal->watch->asking_price,
                'status' => $request->status === Appraisal::STATUS_COMPLETED ? 'available' : 'reserved',
                'description' => $request->watch_description,
            ]);

            $appraisal->update([
                'client_id' => $request->client_id ?? null,
                'appraiser_id' => $request->appraiser_id,
                'appraised_value' => $request->appraised_value ?? $appraisal->appraised_value,
                'condition_notes' => $request->condition_notes ?? $appraisal->condition_notes,
                'review_notes' => $request->review_notes ?? $appraisal->review_notes,
                'has_box' => $request->boolean('has_box'),
                'has_papers' => $request->boolean('has_papers'),
                'status' => $request->status,
                'completed_at' => in_array($request->status, [Appraisal::STATUS_COMPLETED, Appraisal::STATUS_REJECTED], true) ? now() : null,
            ]);

            ActivityLogService::logUpdate($appraisal, $oldValues, 'Appraisal workflow updated.');
        });
        return redirect()->route('appraisals.index')->with('success','Appraisal updated.');
    }
    public function markChecking(Appraisal $appraisal)
    {
        $oldValues = $appraisal->only(['status']);

        $appraisal->update([
            'status' => Appraisal::STATUS_CHECKING,
            'completed_at' => null,
        ]);

        ActivityLogService::logUpdate($appraisal, $oldValues, 'Appraisal moved to checking.');

        return back()->with('success', 'Appraisal sent for checking.');
    }

    public function reject(Appraisal $appraisal)
    {
        $oldValues = $appraisal->only(['status']);

        $appraisal->update([
            'status' => Appraisal::STATUS_REJECTED,
            'completed_at' => now(),
        ]);

        ActivityLogService::logUpdate($appraisal, $oldValues, 'Appraisal rejected.');

        return back()->with('success', 'Appraisal marked as rejected.');
    }
    public function destroy(Appraisal $appraisal) { $appraisal->delete(); return redirect()->route('appraisals.index')->with('success','Appraisal deleted.'); }
}