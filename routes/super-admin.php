<?php

use App\Http\Controllers\SuperAdmin\AllocationController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified', 'role:super-admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Allocation
    Route::get('/allocation', [AllocationController::class, 'index'])->name('admin.allocation.index');
    Route::post('/allocation', [AllocationController::class, 'store'])->name('admin.allocation.store');
    Route::put('/allocation/{allocation}', [AllocationController::class, 'update'])->name('admin.allocation.update');
    Route::delete('/allocation/{allocation}', [AllocationController::class, 'destroy'])->name('admin.allocation.destroy');
});
