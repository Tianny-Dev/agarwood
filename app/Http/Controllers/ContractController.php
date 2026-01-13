<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Contract;

class ContractController extends Controller
{
    public function pending(Request $request)
    {
        $user = $request->user();

        $contract = $user->investor?->contract
            ? [
                'id' => $user->investor->contract->id,
                'contract_number' => $user->investor->contract->contract_number,
                'status' => $user->investor->contract->status,
            ]
            : null;

        return Inertia::render('contract/Pending', [
            'contract' => $contract,
        ]);
    }
}
