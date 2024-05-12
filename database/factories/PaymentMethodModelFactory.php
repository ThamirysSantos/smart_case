<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentMethodModelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'slug' => fake()->unique()->randomElement(['PIX, BOLETO, BANK_TRANSFER']),
        ];
    }
}