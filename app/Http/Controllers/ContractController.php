<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Contract;

class ContractController extends Controller
{
    public function pending(Request $request)
    {
        $contract = $request->user()->activeContract();

        return Inertia::render('contract/Pending', [
            'contract' => $contract ? [
                'id' => $contract->id,
                'contract_number' => $contract->contract_number,
                'status' => $contract->status,
            ] : null,
        ]);
    }
}
