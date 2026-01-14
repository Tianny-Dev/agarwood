<?php

namespace Database\Factories;

use App\Models\Agent;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agent>
 */
class AgentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), 
            'agent_code' => $this->generateUniqueAgentCode(),
            'is_verified' => $this->faker->boolean(30),
            'verified_at' => null, 
            'verified_by' => null,
        ];
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

    /**
     * Mark the agent as verified
     */
    public function verified($adminId = null): static
    {
        return $this->state(fn (array $attributes) => [
            'is_verified' => true,
            'verified_at' => now(),
            'verified_by' => $adminId,
        ]);
    }
}
