<?php

use App\Http\Controllers\Partner\DashboardController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified', 'contract.approved'])->prefix('partner')->name('partner.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
