<?php

use App\Http\Controllers\Agent\DashboardController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified', 'role:agent', 'agent.verified'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'verified', 'role:agent', 'agent.unverified.only'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/not-verified', function () {
        return Inertia::render('agent/NotVerified',);
    })->name('verification.notice');
});