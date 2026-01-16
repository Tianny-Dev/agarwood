<?php

use App\Http\Controllers\SuperAdmin\AgentVerificationController;
use App\Http\Controllers\SuperAdmin\AllocationController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\FarmerVerificationController;
use App\Http\Controllers\SuperAdmin\InvestorController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified', 'role:super-admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Agents
    Route::resource('agents', AgentVerificationController::class)->only(['index']);
    Route::resource('farmers', FarmerVerificationController::class)->only(['index']);
    Route::patch('farmers/{farmer}/status', [FarmerVerificationController::class, 'updateStatus'])->name('farmers.status');

    Route::resource('investors', InvestorController::class)->only(['index']);


    // Allocation
    Route::get('/allocation', [AllocationController::class, 'index'])->name('admin.allocation.index');
    Route::post('/allocation', [AllocationController::class, 'store'])->name('admin.allocation.store');
    Route::put('/allocation/{allocation}', [AllocationController::class, 'update'])->name('admin.allocation.update');
    Route::delete('/allocation/{allocation}', [AllocationController::class, 'destroy'])->name('admin.allocation.destroy');
});
