<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvestorResource;
use App\Models\Investor;
use App\Models\Agent;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvestorController extends Controller
{
    public function index(Request $request)
    {
        $investors = Investor::query()
            ->with(['user', 'agent.user'])
            ->when($request->status, function ($query, $status) {
                if ($status === 'paid') $query->where('is_paid', true);
                if ($status === 'unpaid') $query->where('is_paid', false);
            })
            ->when($request->agent_name, function ($query, $agentName) {
                $query->whereHas('agent.user', function ($q) use ($agentName) {
                    $q->whereRaw("CONCAT(first_name, ' ', last_name) = ?", [$agentName]);
                });
            })
            ->when($request->search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('first_name', 'LIKE', "%{$search}%")
                      ->orWhere('last_name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        // Get list of agents who have investors for the filter
        $agentsList = Agent::whereHas('investors')->with('user')->get()
            ->map(fn($a) => [
                'label' => "{$a->user->first_name} {$a->user->last_name}",
                'value' => "{$a->user->first_name} {$a->user->last_name}"
            ]);

        return Inertia::render('super-admin/investor/Index', [
            'investors' => InvestorResource::collection($investors)->resolve(),
            'agents_list' => $agentsList,
            'filters' => $request->only(['status', 'agent_name', 'search']),
        ]);
    }
}
