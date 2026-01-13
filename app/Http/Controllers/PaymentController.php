<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Services\Contract\ContractPaymentService;
use App\Services\PayMongoService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected PayMongoService $paymongo;
    protected ContractPaymentService $contractPayment;

    public function __construct(PayMongoService $paymongo, ContractPaymentService $contractPayment)
    {
        $this->paymongo = $paymongo;
        $this->contractPayment = $contractPayment;
    }

    public function pay(Contract $contract)
    {
        if ($contract->status !== 'unpaid') {
            return response()->json(['message' => 'Already paid'], 409);
        }

        $checkout = $this->paymongo->createCheckoutSession(
            $contract->contract_number,
            10000 * 100,
            route('contract.payment.success', $contract),
            route('contract.pending')
        );

        $contract->update([
            'checkout_session_id' => $checkout['id'],
        ]);

        return response()->json([
            'checkout_url' => $checkout['checkout_url'],
        ]);
    }

    public function handlePaid(Contract $contract)
    {
        $this->contractPayment->markAsPaid($contract);

        return redirect()->route('dashboard');
    }

    public function handleFailed(Contract $contract)
    {
        $contract->update(['checkout_session_id' => null]);
        return redirect()->route('dashboard');
    }

    public function handleCancelledOrExpired(Contract $contract)
    {
        $contract->update(['checkout_session_id' => null]);
        return redirect()->route('dashboard');
    }
}
