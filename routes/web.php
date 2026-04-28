<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WatchController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AppraisalController;
use App\Http\Controllers\ConsignmentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Allow authenticated users to see a pending approval page before the approved middleware blocks them
Route::middleware(['auth'])->group(function () {
    Route::get('/approval-pending', function () {
        return view('auth.approval_pending');
    })->name('approval.pending');
});

// Main app routes require authentication and approval
Route::middleware(['auth','approved'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('watches', WatchController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('appraisals', AppraisalController::class);
    Route::resource('consignments', ConsignmentController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('payments', PaymentController::class);

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::resource('users', UserController::class);
        Route::post('users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
    });
});

require __DIR__.'/auth.php';