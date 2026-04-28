<?php
namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\Watch;
use App\Models\Consignment;
use App\Models\Payment;
use App\Models\Appraisal;

class ReportController extends Controller {
    public function index() {
        // Sales Report
        $totalSales = Transaction::sales()->sum('amount');
        $salesCount = Transaction::sales()->count();
        $salesData = Transaction::sales()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('date')
            ->latest('date')
            ->take(30)
            ->get();

        // Revenue Report
        $confirmedPayments = Payment::confirmed()->sum('amount');
        $pendingPayments = Payment::pending()->sum('amount');
        $paymentsByMethod = Payment::confirmed()
            ->selectRaw('method, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('method')
            ->get();

        // Inventory Report - aggregate in PHP to avoid SQL reserved-word and ONLY_FULL_GROUP_BY issues
        $watchesBycondition = Watch::query()
            ->get(['condition', 'cost_price', 'asking_price'])
            ->map(function ($w) {
                $w->condition_label = $w->condition === null || $w->condition === '' ? 'Unknown' : $w->condition;
                return $w;
            })
            ->groupBy('condition_label')
            ->map(function ($group, $label) {
                return (object) [
                    'condition' => $label,
                    'count' => $group->count(),
                    'total_cost' => $group->sum('cost_price'),
                    'total_asking' => $group->sum('asking_price'),
                ];
            })->values();
        $watchesByStatus = Watch::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Consignment Report
        $activeConsignments = Consignment::active()->count();
        $consignmentValue = Consignment::active()->sum('agreed_price');

        // Appraisal Report
        $appraisalsCompleted = Appraisal::completed()->count();
        $appraisalsPending = Appraisal::pending()->count();

        // Top Performers
        $topClients = Transaction::with('client')
            ->selectRaw('client_id, COUNT(*) as transaction_count, SUM(amount) as total_spent')
            ->groupBy('client_id')
            ->orderByDesc('total_spent')
            ->take(10)
            ->get();

        return view('reports.index', compact(
            'totalSales',
            'salesCount',
            'confirmedPayments',
            'pendingPayments',
            'paymentsByMethod',
            'watchesBycondition',
            'watchesByStatus',
            'activeConsignments',
            'consignmentValue',
            'appraisalsCompleted',
            'appraisalsPending',
            'topClients'
        ));
    }

    public function salesReport()
    {
        $startDate = request('start_date', now()->subMonths(3)->toDateString());
        $endDate = request('end_date', now()->toDateString());

        $transactions = Transaction::sales()
            ->with(['watch', 'client', 'staff'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderByDesc('created_at')
            ->get();

        return view('reports.sales', compact('transactions', 'startDate', 'endDate'));
    }

    public function inventoryReport()
    {
        $watches = Watch::selectRaw('brand, model, COUNT(*) as total, AVG(asking_price) as avg_price, SUM(cost_price) as total_cost')
            ->groupBy('brand', 'model')
            ->orderByDesc('total')
            ->get();

        return view('reports.inventory', compact('watches'));
    }

    public function consignmentReport()
    {
        $consignments = Consignment::with(['watch', 'client'])->get();
        return view('reports.consignments', compact('consignments'));
    }
}