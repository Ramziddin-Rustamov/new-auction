<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->word(), 
            'img' => $this->faker->imageUrl(), 
            'bidmargin' => $this->faker->numberBetween(10000, 20000),
            'description' => $this->faker->paragraph(2),
        ];
    }
}
