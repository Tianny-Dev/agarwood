<?php

use App\Http\Controllers\Farmer\AgentController;
use App\Http\Controllers\Farmer\DashboardController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified', 'role:farmer'])->prefix('farmer')->name('farmer.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('agents', AgentController::class);
});
