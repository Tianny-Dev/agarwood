<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contractable_type' => null, // set manually with ->forModel()
            'contractable_id' => null,
            'contract_number' => 'AGR-' . strtoupper(Str::random(8)),
            'status' => $this->faker->randomElement(['unpaid', 'paid', 'approved', 'rejected']),
            'file_path' => 'contracts/' . Str::uuid() . '.pdf',
        ];
    }

    /**
     * Associate contract with a specific model.
     */
    public function forModel($model)
    {
        return $this->state(function () use ($model) {
            return [
                'contractable_type' => get_class($model),
                'contractable_id' => $model->id,
            ];
        });
    }

    /**
     * Convenience state for unpaid contracts.
     */
    public function unpaid()
    {
        return $this->state([
            'status' => 'unpaid',
        ]);
    }

    /**
     * Convenience state for approved contracts.
     */
    public function approved()
    {
        return $this->state([
            'status' => 'approved',
        ]);
    }
}
