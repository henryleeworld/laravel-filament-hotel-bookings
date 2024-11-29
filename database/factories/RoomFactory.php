<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'        => fake()->words(2, asText: true),
            'description' => fake()->text(),
            'price'       => fake()->randomNumber(random_int(3, 5)),

            'hotel_id' => Hotel::factory(),
        ];
    }
}
