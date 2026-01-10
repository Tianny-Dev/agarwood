<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Farmer>
 */
class FarmerFactory extends Factory
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
            'farming_background' => $this->faker->sentence(10),
            'years_of_farming' => $this->faker->numberBetween(1, 40),
            'familiarity_tree_cultivation' => $this->faker->randomElement([
                true, false,
            ]),
        ];
    }
}
