<?php

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\PaymentController; 
use App\Services\DashboardResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->prefix('contract')->name('contract.')->group(function () {
    Route::get('pending', [ContractController::class, 'pending'])->name('pending')->middleware('redirect.if.contract.paid');

    Route::post('/{contract}/pay', [PaymentController::class, 'pay'])->name('pay');

    Route::get('/payment/success/{contract}', [PaymentController::class, 'handlePaid'])->name('payment.success');
    Route::get('/payment/cancel/{contract}', [PaymentController::class, 'handleCancelledOrExpired'])->name('payment.cancel');
    Route::get('/payment/expired/{contract}', [PaymentController::class, 'handleCancelledOrExpired'])->name('payment.expired');
});

Route::get('/dashboard', function (Request $request, DashboardResolver $resolver) {
    return redirect($resolver->resolve($request->user()));
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/investor.php';
require __DIR__.'/farmer.php';
