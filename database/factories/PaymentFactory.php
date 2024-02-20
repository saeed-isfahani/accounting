<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = $this->faker->biasedNumberBetween(100, 100000);
        $rate = $this->faker->biasedNumberBetween(10, 10000000);
        return [
            'currency' => $this->faker->randomElement(['usd', 'eur', 'cny', 'aed']),
            'amount' => $amount,
            'rate' => $rate,
            'amount_in_rate' => $amount * $rate
        ];
    }
}
