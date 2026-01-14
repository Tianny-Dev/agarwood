<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\AgentStoreRequest;
use App\Http\Requests\Agent\AgentUpdateRequest;
use App\Http\Resources\AgentResource;
use App\Models\Agent;
use App\Models\User;
use App\Services\Auth\RegisterUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $farmer = Auth::user()->farmer;

        if (!$farmer) {
            return Inertia::render('farmer/agent/Index', [
                'agents' => [],
                'error' => 'No farmer profile found.',
            ]);
        }

        $agents = $farmer->agents()->with('user', 'qrCode')->get();

        return Inertia::render('farmer/agent/Index', [
            'agents' => AgentResource::collection($agents)->resolve(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('farmer/agent/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AgentStoreRequest $request, RegisterUserService $registerUserService)
    {
        $farmer = Auth::user()->farmer;

        if (!$farmer) {
            return redirect()->back()->withErrors(['farmer' => 'No farmer profile found.']);
        }

        $request->merge([
            'farmer_id' => $farmer->id,
        ]);

        $user = $registerUserService->register($request);

        return redirect()->route('farmer.agents.show', $user->agent->id)->with('success', 'Agent created successfully.');
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

        return Inertia::render('farmer/agent/Show', [
            'agent' => (new AgentResource($agent))->resolve(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agent $agent)
    {
        $agent->load('user');

        return Inertia::render('farmer/agent/Edit', [
            'agent' => new AgentResource($agent),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AgentUpdateRequest $request, Agent $agent)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $agent) {
            // Update User data
            $agent->user()->update([
                'username' => $data['username'],
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'] ?? null,
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'birthday' => $data['birthday'],
                'gender' => $data['gender'],
                'address' => $data['address'],
                'civil_status' => $data['civil_status'],
                'password' => $data['password'] ? Hash::make($data['password']) : $agent->user->password,
            ]);

            // Optionally: update agent verification status
            if (isset($data['is_verified'])) {
                $agent->update([
                    'is_verified' => $data['is_verified'],
                    'verified_at' => $data['is_verified'] ? now() : null,
                    'verified_by' => $data['is_verified'] ? Auth::id() : null,
                ]);
            }
        });

        return redirect()->route('farmer.agents.index')->with('success', 'Agent updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agent $agent)
    {
        DB::transaction(function () use ($agent) {
            $agent->user()->delete(); 
        });

        return redirect()->route('farmer.agents.index')->with('success', 'Agent deleted successfully.');
    }
}
