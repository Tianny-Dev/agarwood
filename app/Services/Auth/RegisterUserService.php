<?php

namespace App\Services\Auth;

use App\Models\Agent;
use App\Models\User;
use App\Services\Contract\ContractRegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegisterUserService
{
    public function register(Request $request): User
    {
        $data = $request->validated();

        if (($data['user_type'] ?? null) === 'agent' && !isset($data['farmer_id'])) {
            $data['farmer_id'] = $request->user()->farmer->id ?? null;
        }

        return DB::transaction(function () use ($data, $request) {

            $user = $this->createUser($data);

            $this->createRole($user, $data, $request);

            return $user;
        });
    }

    protected function createUser(array $data): User
    {
        $roleCode = match ($data['user_type']) {
            'agent' => 2,
            'farmer' => 3,
            'investor' => 4,
            'partner' => 5,
            default => 3,
        };

        $year = date('y');

        $lastUser = User::where('role_id', 'LIKE', "{$roleCode}-{$year}-%")
            ->lockForUpdate()
            ->orderByDesc('role_id')
            ->first();

        $newNumber = $lastUser
            ? ((int) substr($lastUser->role_id, -4)) + 1
            : 1;

        return User::create([
            'role_id' => "{$roleCode}-{$year}-" . str_pad($newNumber, 4, '0', STR_PAD_LEFT),
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'] ?? null,
            'last_name' => $data['last_name'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'birthday' => $data['birthday'],
            'gender' => $data['gender'],
            'civil_status' => $data['civil_status'],
            'address' => $data['address'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function createRole(User $user, array $data, Request $request): void
    {
        switch ($data['user_type']) {

            case 'agent':
                $user->agent()->create([
                    'agent_code' => $this->generateUniqueAgentCode(),
                    'farmer_id' => $data['farmer_id'] ?? null,
                ]);
                break;

            case 'farmer':
                $user->farmer()->create([
                    'farming_background' => $data['farming_background'] ?? null,
                    'years_of_farming' => $data['years_of_farming'] ?? null,
                    'familiarity_tree_cultivation' => $data['familiarity_tree_cultivation'] ?? false,
                ]);
                break;

            case 'investor':
            case 'partner':
                $agentId = null;
                if (!empty($data['agent_code'])) {
                    $agent = Agent::query()->where('agent_code', $data['agent_code'])->first();
                    if ($agent) {
                        $agentId = $agent->id;
                    } else {
                        throw ValidationException::withMessages([
                            'agent_code' => ['The provided agent code is invalid.'],
                        ]);
                    }
                }

                $data['agent_id'] = $agentId;

                app(ContractRegistrationService::class)
                    ->create($data['user_type'], $user, $data, $request);
                break;

            default:
                throw new \InvalidArgumentException("Invalid user type: {$data['user_type']}");
        }
    }

    /**
     * Generate a unique agent code
     */
    protected function generateUniqueAgentCode(): string
    {
        do {
            $code = 'AGT-' 
            . strtoupper(Str::random(3)) 
            . str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);
        } while (Agent::query()->where('agent_code', $code)->exists());

        return $code;
    }
}
