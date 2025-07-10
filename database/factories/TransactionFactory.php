<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeThisMonth();
        return [
            'start_date' => $startDate,
            'end_date' => Carbon::createFromDate($startDate)->addDays(fake()->numberBetween(1, 7)),
            'status' => fake()->randomElement(['waiting', 'approved', 'canceled'])
        ];
    }
}
