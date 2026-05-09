<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WatchController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientSearchController;
use App\Http\Controllers\AppraisalController;
use App\Http\Controllers\ConsignmentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Main app routes require authentication and role-based access
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/clients/search', [ClientSearchController::class, 'search'])->name('clients.search');

    Route::resource('watches', WatchController::class);
    Route::post('watches/bulk-action', [WatchController::class, 'bulkAction'])->name('watches.bulkAction');
    Route::post('watches/bulk-price', [WatchController::class, 'bulkPrice'])->name('watches.bulkPrice');
    Route::post('watches/save-filter', [WatchController::class, 'saveFilter'])->name('watches.saveFilter');
    Route::get('watches/{id}/restore', [WatchController::class, 'restore'])->name('watches.restore');
    Route::get('watches/filter/{filter}', [WatchController::class, 'applyFilter'])->name('watches.applyFilter');
    
    Route::resource('clients', ClientController::class);
    Route::resource('appraisals', AppraisalController::class);
    Route::post('appraisals/{appraisal}/checking', [AppraisalController::class, 'markChecking'])->name('appraisals.checking');
    Route::post('appraisals/{appraisal}/reject', [AppraisalController::class, 'reject'])->name('appraisals.reject');
    Route::resource('consignments', ConsignmentController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('payments', PaymentController::class);

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::resource('users', UserController::class);
        Route::resource('activity-logs', ActivityLogController::class, ['only' => ['index', 'show']]);
    });
});

require __DIR__.'/auth.php';