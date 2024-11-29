<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        User::factory()
            ->has(
                Hotel::factory()
                    ->hasRooms(random_int(1, 3))
            )
            ->create(['email' => 'hotel@admin.com'])
            ->assignRole('hotels');

        User::factory()
            ->create(['email' => 'booking@admin.com'])
            ->assignRole('customers');
    }
}
