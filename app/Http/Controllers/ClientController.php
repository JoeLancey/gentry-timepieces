<?php
namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller {
    public function index() { return view('clients.index', ['clients' => Client::latest()->paginate(15)]); }
    public function create() { return view('clients.create'); }
    public function store(Request $request) {
        $request->validate(['first_name'=>'required','last_name'=>'required','phone'=>'required','email'=>'nullable|email']);
        Client::create($request->only('first_name','last_name','phone','email','address','notes'));
        return redirect()->route('clients.index')->with('success','Client saved.');
    }
    public function show(Client $client) { return view('clients.show', compact('client')); }
    public function edit(Client $client) { return view('clients.edit', compact('client')); }
    public function update(Request $request, Client $client) {
        $request->validate(['first_name'=>'required','last_name'=>'required','phone'=>'required','email'=>'nullable|email']);
        $client->update($request->only('first_name','last_name','phone','email','address','notes'));
        return redirect()->route('clients.index')->with('success','Client updated.');
    }
    public function destroy(Client $client) { $client->delete(); return redirect()->route('clients.index')->with('success','Client deleted.'); }
}