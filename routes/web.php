<?php

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\PaymentController; 
use App\Services\DashboardResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

// Contract-related routes
Route::prefix('contract')->name('contract.')->group(function () {
    Route::get('pending', [ContractController::class, 'pending'])
        ->name('pending');
    });
});

Route::get('/dashboard', function (Request $request, DashboardResolver $resolver) {
    return redirect($resolver->resolve($request->user()));
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/investor.php';
