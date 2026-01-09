<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Home\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dasboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});
