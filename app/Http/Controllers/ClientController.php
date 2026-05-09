<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ActivityLog;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::withCount(['transactions', 'consignments', 'appraisals'])
            ->when(request('search'), fn($q) => $q->search(request('search')))
            ->latest()
            ->paginate(15);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'notes' => 'nullable|string',
        ]);

        $client = Client::create($validated);
        ActivityLogService::logCreate($client, 'New client added: ' . $client->full_name);
        return redirect()->route('clients.index')->with('success', 'Client added successfully.');
    }

    public function show(Client $client)
    {
        // Load insights
        $totalTransactions = $client->transactions()->count();
        $totalSpent = $client->transactions()->sum('amount');
        
        // Calculate total paid through transactions' payments
        $totalPaid = $client->transactions()
            ->join('payments', 'transactions.id', '=', 'payments.transaction_id')
            ->whereIn('payments.status', ['confirmed', 'completed'])
            ->sum('payments.amount');
        
        $outstandingBalance = $totalSpent - $totalPaid;
        $averageSpend = $totalTransactions > 0 ? $totalSpent / $totalTransactions : 0;
        $recentTransactions = $client->transactions()->with(['watch', 'payments'])->latest()->take(10)->get();
        $timeline = ActivityLog::where('model_type', 'Client')
            ->where('model_id', $client->id)
            ->latest()
            ->take(8)
            ->get();

        return view('clients.show', compact(
            'client',
            'totalTransactions',
            'totalSpent',
            'totalPaid',
            'outstandingBalance',
            'averageSpend',
            'recentTransactions',
            'timeline'
        ));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $oldValues = $client->getAttributes();
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'notes' => 'nullable|string',
        ]);

        $client->update($validated);
        ActivityLogService::logUpdate($client, $oldValues, 'Client updated: ' . $client->full_name);
        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        ActivityLogService::logDelete($client, 'Client deleted: ' . $client->full_name);
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }
}