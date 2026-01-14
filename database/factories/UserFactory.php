<?php

namespace Database\Factories;

use App\Enums\CivilStatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    private static array $lastNumbers = [
        'super_admin' => 0,
        'agent' => 0,
        'farmer' => 0,
        'investor' => 0,
        'partner' => 0,
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role_id' => null,
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->lastName(),
            'last_name' => fake()->lastName(),
            'phone_number' => fake()->unique()->numerify('639#########'),
            'phone_number_verified_at' => fake()->boolean(70) ? now() : null,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'birthday' => fake()->date(),
            'gender' => fake()->randomElement(['male', 'female', 'other']),
            'civil_status' => fake()->randomElement(['single', 'married', 'widowed', 'separated', 'divorced']),
            'address' => fake()->address,
            'password' => self::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Configure the factory to set role_id based on relationships.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (User $user) {
            if ($user->role_id) {
                return;
            }

            $role = $this->determineRoleFromRelationships();
            $user->role_id = $this->generateRoleId($role);
        });
    }

    /**
     * Determine role from the relationships being created
     */
    private function determineRoleFromRelationships(): string
    {
        return 'farmer';
    }

    /**
     * Generate a unique role-based ID.
     */
    private function generateRoleId($role)
    {
        switch ($role) {
            case 'super_admin': $roleCode = 1; break;
            case 'agent': $roleCode = 2; break;
            case 'farmer': $roleCode = 3; break;
            case 'investor': $roleCode = 4; break;
            case 'partner': $roleCode = 5; break;
            default: $roleCode = 3; break;
        }

        $year = date('y');

        $lastNumber = self::$lastNumbers[$role] ?? 0;
        $newNumber = $lastNumber + 1;
        self::$lastNumbers[$role] = $newNumber;

        return "{$roleCode}-{$year}-" . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Reset all role counters to 0
     */
    public static function resetCounters(): void
    {
        self::$lastNumbers = [
            'super_admin' => 0,
            'agent' => 0,
            'farmer' => 0,
            'investor' => 0,
            'partner' => 0,
        ];
    }

    /**
     * Set a specific role counter
     */
    public static function setCounter(string $role, int $count): void
    {
        if (isset(self::$lastNumbers[$role])) {
            self::$lastNumbers[$role] = $count;
        }
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Create a farmer user
     */
    public function farmer(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => $this->generateRoleId('farmer'),
            ];
        });
    }

    /**
     * Create an investor user
     */
    public function investor(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => $this->generateRoleId('investor'),
            ];
        });
    }

    /**
     * Create a partner user
     */
    public function partner(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => $this->generateRoleId('partner'),
            ];
        });
    }

    /**
     * Create an agent user
     */
    public function agent(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => $this->generateRoleId('agent'),
            ];
        });
    }

    /**
     * Indicate that the model has two-factor authentication configured.
     */
    public function withTwoFactor(): static
    {
        return $this->state(fn (array $attributes) => [
            'two_factor_secret' => encrypt('secret'),
            'two_factor_recovery_codes' => encrypt(json_encode(['recovery-code-1'])),
            'two_factor_confirmed_at' => now(),
        ]);
    }

    /**
     * Indicate that the model does not have two-factor authentication configured.
     */
    public function withoutTwoFactor(): static
    {
        return $this->state(fn (array $attributes): array => [
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);
    }
}