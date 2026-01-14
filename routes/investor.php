<?php

use App\Http\Controllers\Investor\DashboardController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified', 'contract.approved', 'role:investor'])->prefix('investor')->name('investor.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
