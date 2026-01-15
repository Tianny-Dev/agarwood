<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AgentResource;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AgentVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agents = Agent::query()
            ->with(['user', 'qrCode'])
            ->latest()
            ->get();

        return inertia()->render('super-admin/agent/Index', [
            'agents' => AgentResource::collection($agents)->resolve(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Agent $agent)
    {
        $agent->load(['user', 'qrCode']);

        if (!$agent->user) {
            abort(404, 'User not found for this agent.');
        }

        return Inertia::render('super-admin/agent/Show', [
            'agent' => (new AgentResource($agent))->resolve(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agent $agent)
    {
        $request->validate([
            'is_verified' => 'required|boolean',
        ]);

        $agent->update([
            'is_verified' => $request->is_verified,
            'verified_at' => now(),
            'verified_by'   => Auth::id(),
        ]);

        return redirect()->route('super-admin.agents.index')->with('success', 'Agent created successfully.');
    }
}
