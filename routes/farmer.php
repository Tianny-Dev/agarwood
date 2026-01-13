<?php

use App\Http\Controllers\Farmer\DashboardController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified'])->prefix('farmer')->name('farmer.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
