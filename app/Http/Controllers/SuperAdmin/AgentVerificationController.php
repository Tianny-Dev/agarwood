<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AgentResource;
use App\Models\Agent;
use App\Models\Farmer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AgentVerificationController extends Controller
{
    public function index(Request $request)
{
    $agents = Agent::query()
        ->with(['user', 'qrCode', 'farmer.user'])
        ->when($request->status, function ($query, $status) {
            if ($status === 'verified') $query->where('is_verified', true);
            if ($status === 'unverified') $query->where('is_verified', false);
        })
        ->when($request->farmer, function ($query, $farmerName) {
            $query->whereHas('farmer.user', function ($q) use ($farmerName) {
                $q->whereRaw("CONCAT(first_name, ' ', last_name) = ?", [$farmerName]);
            });
        })
        ->when($request->agent_name, function ($query, $agentName) {
            $query->whereHas('user', function ($q) use ($agentName) {
                $q->whereRaw("CONCAT(first_name, ' ', last_name) = ?", [$agentName]);
            });
        })
        ->latest()
        ->get();

    $farmers = Farmer::whereHas('agents')->with('user')->get()
        ->map(fn($f) => [
            'label' => "{$f->user->first_name} {$f->user->last_name}",
            'value' => "{$f->user->first_name} {$f->user->last_name}"
        ]);

    // Include the associated farmer's name in the agent list for frontend filtering
    $allAgentsList = Agent::with(['user', 'farmer.user'])->get()
        ->map(fn($a) => [
            'label' => "{$a->user->first_name} {$a->user->last_name}",
            'value' => "{$a->user->first_name} {$a->user->last_name}",
            'farmer_name' => $a->farmer?->user
                ? "{$a->farmer->user->first_name} {$a->farmer->user->last_name}"
                : null
        ]);

    return inertia()->render('super-admin/agent/Index', [
        'agents' => AgentResource::collection($agents)->resolve(),
        'farmers_list' => $farmers,
        'agents_list' => $allAgentsList,
        'filters' => $request->only(['status', 'farmer', 'agent_name']),
    ]);
}
}
