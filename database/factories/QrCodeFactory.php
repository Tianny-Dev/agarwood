<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QrCode>
 */
class QrCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'qrable_type' => null,
            'qrable_id' => null,

            'code' => Str::uuid(),
            'image_path' => 'qr/' . $this->faker->uuid() . '.png',
        ];
    }

    /**
     * Associate QR code with a specific model.
     */
    public function forModel($model)
    {
        return $this->state(function () use ($model) {
            return [
                'qrable_type' => get_class($model),
                'qrable_id' => $model->id,
            ];
        });
    }
}
