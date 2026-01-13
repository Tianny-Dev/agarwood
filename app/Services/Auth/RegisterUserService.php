<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Contract\ContractRegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterUserService
{
    public function register(Request $request): User
    {
        $data = $request->validated();

        return DB::transaction(function () use ($data, $request) {

            $user = $this->createUser($data);

            $this->createRole($user, $data, $request);

            return $user;
        });
    }

    protected function createUser(array $data): User
    {
        $roleCode = match ($data['user_type']) {
            'farmer' => 2,
            'investor' => 3,
            'partner' => 4,
            default => 1,
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
        match ($data['user_type']) {
            'farmer' => $user->farmer()->create([
                'farming_background' => $data['farming_background'] ?? null,
                'years_of_farming' => $data['years_of_farming'] ?? null,
                'familiarity_tree_cultivation' => $data['familiarity_tree_cultivation'] ?? false,
            ]),

            'investor', 'partner' =>
                app(ContractRegistrationService::class)
                    ->create($data['user_type'], $user, $data, $request),
        };
    }
}
