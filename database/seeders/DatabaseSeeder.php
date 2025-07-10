<?php

namespace Database\Seeders;

use App\Models\listing;
use App\Models\Transaction;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin Rent House',
            'email' => 'admin@houserent.test',
            'role' => 'admin',
        ]);

        $users = User::factory(10)->create();
        $listings = listing::factory(10)->create();

        Transaction::factory(10)
        ->state(
            new Sequence(
                fn(Sequence $sequence) => [
                    'user_id' => $users->random(),
                    'listing_id' => $listings->random(),
                ]
            )
        )->create();
    }
}
