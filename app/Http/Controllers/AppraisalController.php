<?php
namespace App\Http\Controllers;
use App\Models\Appraisal;
use App\Models\Watch;
use App\Models\Client;
use App\Models\User;
use App\Http\Requests\StoreAppraisalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppraisalController extends Controller {
    public function index() { return view('appraisals.index', ['appraisals' => Appraisal::with(['watch','client','appraiser'])->latest()->paginate(15)]); }
    public function create() { return view('appraisals.create', ['clients'=>Client::all(),'appraisers'=>User::where('role', 'staff')->get()]); }
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
                'asking_price' => $request->appraised_value,
                'cost_price' => 0,
                'status' => 'available',
                'description' => $request->watch_description,
            ]);

            Appraisal::create([
                'watch_id' => $watch->id,
                'client_id' => $request->client_id,
                'appraiser_id' => $request->appraiser_id,
                'appraised_value' => $request->appraised_value,
                'condition_notes' => $request->condition_notes,
                'has_box' => $request->boolean('has_box'),
                'has_papers' => $request->boolean('has_papers'),
                'status' => $request->status,
            ]);
        });
        return redirect()->route('appraisals.index')->with('success','Appraisal saved.');
    }
    public function show(Appraisal $appraisal) { return view('appraisals.show', compact('appraisal')); }
    public function edit(Appraisal $appraisal) { return view('appraisals.edit', ['appraisal'=>$appraisal,'appraisers'=>User::where('role', 'staff')->get()]); }
    public function update(Request $request, Appraisal $appraisal) {
        $request->validate([
            'watch_brand' => 'required|string|max:100',
            'watch_model' => 'required|string|max:100',
            'watch_reference_number' => 'nullable|string|max:100',
            'watch_serial_number' => 'required|string|max:100|unique:watches,serial_number,' . $appraisal->watch_id,
            'watch_year_produced' => 'nullable|integer|min:1800|max:' . now()->year,
            'watch_condition' => 'required|in:mint,excellent,good,fair',
            'watch_has_box' => 'boolean',
            'watch_has_papers' => 'boolean',
            'watch_description' => 'nullable|string|max:1000',
            'client_id' => 'required|exists:clients,id',
            'appraiser_id' => 'required|exists:users,id',
            'appraised_value' => 'required|numeric|min:0',
            'condition_notes' => 'required|string|max:1000',
            'has_box' => 'boolean',
            'has_papers' => 'boolean',
            'status' => 'required|in:pending,completed,rejected',
        ]);

        DB::transaction(function () use ($request, $appraisal) {
            $appraisal->watch->update([
                'brand' => $request->watch_brand,
                'model' => $request->watch_model,
                'reference_number' => $request->watch_reference_number,
                'serial_number' => $request->watch_serial_number,
                'year_produced' => $request->watch_year_produced,
                'condition' => $request->watch_condition,
                'has_box' => $request->boolean('watch_has_box'),
                'has_papers' => $request->boolean('watch_has_papers'),
                'asking_price' => $request->appraised_value,
                'description' => $request->watch_description,
            ]);

            $appraisal->update([
                'client_id' => $request->client_id,
                'appraiser_id' => $request->appraiser_id,
                'appraised_value' => $request->appraised_value,
                'condition_notes' => $request->condition_notes,
                'has_box' => $request->boolean('has_box'),
                'has_papers' => $request->boolean('has_papers'),
                'status' => $request->status,
            ]);
        });
        return redirect()->route('appraisals.index')->with('success','Appraisal updated.');
    }
    public function destroy(Appraisal $appraisal) { $appraisal->delete(); return redirect()->route('appraisals.index')->with('success','Appraisal deleted.'); }
}