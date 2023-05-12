<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\product>
 */
class cartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->text(25);
        return [
            'product_id' => Product::factory(),
            'user_id' => User::factory(),
            'quantity' => fake()->numberBetween($min = 1, $max = 50),
            'price' => fake()->numberBetween($min = 100, $max = 900),
        ];
    }
}
