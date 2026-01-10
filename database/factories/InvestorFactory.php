<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Investor>
 */
class InvestorFactory extends Factory
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
            'id_type' => fake()->randomElement(['passport', 'drivers_license', 'national_id', 'sss', 'philhealth', 'tin', 'voters_id']),
            'id_front' => $this->faker->imageUrl(640, 480, 'id-front'),
            'id_back' => $this->faker->imageUrl(640, 480, 'id-back'),
        ];
    }
}
