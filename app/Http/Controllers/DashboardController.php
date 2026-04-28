<?php

namespace App\Http\Controllers;

use App\Models\Watch;
use App\Models\Client;
use App\Models\Transaction;
use App\Models\Consignment;
use App\Models\Payment;
use App\Models\Appraisal;
use Throwable;

class DashboardController extends Controller
{
    public function index()
    {
        // Inventory Stats
        try {
            $totalWatches = Watch::count();
            $availableWatches = Watch::available()->count();
            $soldWatches = Watch::where('status', 'sold')->count();
            $consignedWatches = Watch::where('status', 'consigned')->count();
        } catch (Throwable $e) {
            report($e);
            $dbError = 'Database unavailable: please verify your database server and .env settings.';

            // Set safe defaults so the dashboard view can render without errors
            $totalWatches = 0;
            $availableWatches = 0;
            $soldWatches = 0;
            $consignedWatches = 0;

            $totalClients = 0;
            $totalSales = 0;
            $totalCost = 0;
            $totalRevenue = 0;
            $profitMargin = 0;
            $averageProfit = 0;

            $activeConsignments = 0;
            $expiringSoonConsignments = collect();
            $totalConsignmentValue = 0;

            $pendingAppraisals = 0;
            $completedAppraisals = 0;

            $recentTransactions = collect();
            $recentAppraisals = collect();
            $watchsByCondition = collect();

            return view('dashboard', compact(
                'totalWatches',
                'availableWatches',
                'soldWatches',
                'consignedWatches',
                'totalClients',
                'totalSales',
                'totalCost',
                'totalRevenue',
                'profitMargin',
                'averageProfit',
                'activeConsignments',
                'expiringSoonConsignments',
                'totalConsignmentValue',
                'pendingAppraisals',
                'completedAppraisals',
                'recentTransactions',
                'recentAppraisals',
                'watchsByCondition'
            ))->with('db_error', $dbError);
        }

        // Client Stats
        $totalClients = Client::count();

        // Financial Stats
        $totalSales = Transaction::sales()->sum('amount');
        $totalCost = Watch::sum('cost_price');
        $totalRevenue = Payment::confirmed()->sum('amount');
        $profitMargin = $totalRevenue - $totalCost;
        $averageProfit = $totalWatches > 0 ? $profitMargin / $totalWatches : 0;

        // Consignment Stats
        $activeConsignments = Consignment::active()->count();
        $expiringSoonConsignments = Consignment::expiringSoon()->get();
        $totalConsignmentValue = Consignment::active()->sum('agreed_price');

        // Appraisal Stats
        $pendingAppraisals = Appraisal::pending()->count();
        $completedAppraisals = Appraisal::completed()->count();

        // Recent Activity + Top Conditions (guarded)
        try {
            $recentTransactions = Transaction::with(['watch', 'client', 'staff'])->latest()->take(5)->get();
            $recentAppraisals = Appraisal::with(['watch', 'client', 'appraiser'])->latest()->take(5)->get();

            // Top Conditions: aggregate in PHP to avoid SQL mode/group by compatibility issues
            $conditionValues = Watch::query()->pluck('condition');
            $counts = $conditionValues
                ->map(fn($c) => ($c === null || $c === '') ? 'Unknown' : $c)
                ->countBy();

            $watchsByCondition = $counts->map(function ($total, $label) {
                return (object) ['condition_label' => $label, 'total' => $total];
            })->values();
        } catch (Throwable $e) {
            report($e);
            $dbError = 'Database query failed: ' . $e->getMessage();
            $recentTransactions = collect();
            $recentAppraisals = collect();
            $watchsByCondition = collect();

            return view('dashboard', compact(
                'totalWatches',
                'availableWatches',
                'soldWatches',
                'consignedWatches',
                'totalClients',
                'totalSales',
                'totalCost',
                'totalRevenue',
                'profitMargin',
                'averageProfit',
                'activeConsignments',
                'expiringSoonConsignments',
                'totalConsignmentValue',
                'pendingAppraisals',
                'completedAppraisals',
                'recentTransactions',
                'recentAppraisals',
                'watchsByCondition'
            ))->with('db_error', $dbError);
        }

        return view('dashboard', compact(
            'totalWatches',
            'availableWatches',
            'soldWatches',
            'consignedWatches',
            'totalClients',
            'totalSales',
            'totalCost',
            'totalRevenue',
            'profitMargin',
            'averageProfit',
            'activeConsignments',
            'expiringSoonConsignments',
            'totalConsignmentValue',
            'pendingAppraisals',
            'completedAppraisals',
            'recentTransactions',
            'recentAppraisals',
            'watchsByCondition'
        ));
    }
}