<?php

namespace App\Http\Controllers;

use App\Models\Watch;
use App\Models\Client;
use App\Models\Transaction;
use App\Models\Consignment;

class DashboardController extends Controller
{
    public function index()
    {
        $totalWatches     = Watch::count();
        $availableWatches = Watch::where('status', 'available')->count();
        $totalClients     = Client::count();
        $totalSales       = Transaction::where('type', 'sale')->count();
        $activeConsignments = Consignment::where('status', 'active')->count();

        return view('dashboard', compact(
            'totalWatches',
            'availableWatches',
            'totalClients',
            'totalSales',
            'activeConsignments'
        ));
    }
}