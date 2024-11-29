<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        Hotel::factory(5)
            ->hasRooms(random_int(1, 5))
            ->create();
    }
}
