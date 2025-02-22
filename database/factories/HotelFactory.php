<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'      => User::factory(),
            'name'         => fake()->words(asText: true),
            'address'      => fake()->address(),
            'description'  => fake()->text(),
            'is_published' => fake()->boolean(),
        ];
    }
}
