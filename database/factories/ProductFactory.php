<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'name' => fake()->realText($maxNbChars = 10),
            'description' => fake()->realText($maxNbChars = 20),
            'slug' => fake()->realText($maxNbChars = 20),
            'image' => fake()->imageUrl(),
            'price' => fake()->numberBetween($min = 100, $max = 900),
        ];
    }
}
