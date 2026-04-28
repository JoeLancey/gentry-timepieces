<?php
namespace App\Http\Controllers;
use App\Models\Appraisal;
use App\Models\Watch;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class AppraisalController extends Controller {
    public function index() { return view('appraisals.index', ['appraisals' => Appraisal::with(['watch','client','appraiser'])->latest()->paginate(15)]); }
    public function create() { return view('appraisals.create', ['watches'=>Watch::all(),'clients'=>Client::all(),'users'=>User::all()]); }
    public function store(Request $request) {
        $request->validate(['watch_id'=>'required','client_id'=>'required','appraiser_id'=>'required','appraised_value'=>'required|numeric','condition_notes'=>'required','status'=>'required']);
        $data = $request->only('watch_id','client_id','appraiser_id','appraised_value','condition_notes','status');
        $data['has_box'] = $request->boolean('has_box');
        $data['has_papers'] = $request->boolean('has_papers');
        Appraisal::create($data);
        return redirect()->route('appraisals.index')->with('success','Appraisal saved.');
    }
    public function show(Appraisal $appraisal) { return view('appraisals.show', compact('appraisal')); }
    public function edit(Appraisal $appraisal) { return view('appraisals.edit', ['appraisal'=>$appraisal,'watches'=>Watch::all(),'clients'=>Client::all(),'users'=>User::all()]); }
    public function update(Request $request, Appraisal $appraisal) {
        $request->validate(['watch_id'=>'required','client_id'=>'required','appraiser_id'=>'required','appraised_value'=>'required|numeric','condition_notes'=>'required','status'=>'required']);
        $data = $request->only('watch_id','client_id','appraiser_id','appraised_value','condition_notes','status');
        $data['has_box'] = $request->boolean('has_box');
        $data['has_papers'] = $request->boolean('has_papers');
        $appraisal->update($data);
        return redirect()->route('appraisals.index')->with('success','Appraisal updated.');
    }
    public function destroy(Appraisal $appraisal) { $appraisal->delete(); return redirect()->route('appraisals.index')->with('success','Appraisal deleted.'); }
}