<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    private static int $contractNumber = 0;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contract_number' => $this->generateContractNumber(),
            'status' => $this->faker->randomElement(['unpaid', 'paid', 'approved', 'rejected']),
            'checkout_session_id' => $this->faker->boolean(50) ? $this->faker->uuid() : null,
            'file_path' => 'contracts/' . $this->faker->uuid() . '.pdf',
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
     * Generate a unique contract number
     */
    private function generateContractNumber(): string
    {
        self::$contractNumber++;
        $year = date('Y');
        return "CT-{$year}-" . str_pad(self::$contractNumber, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Reset contract number counter
     */
    public static function resetCounter(): void
    {
        self::$contractNumber = 0;
    }

    /**
     * Set contract number counter
     */
    public static function setCounter(int $count): void
    {
        self::$contractNumber = $count;
    }

    /**
     * Mark contract as unpaid
     */
    public function unpaid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'unpaid',
            'checkout_session_id' => null,
        ]);
    }

    /**
     * Mark contract as paid
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
            'checkout_session_id' => $this->faker->uuid(),
        ]);
    }

    /**
     * Mark contract as approved
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
            'checkout_session_id' => $this->faker->uuid(),
        ]);
    }

    /**
     * Mark contract as rejected
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
        ]);
    }
}
