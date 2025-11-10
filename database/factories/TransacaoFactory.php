<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transacao>
 */
class TransacaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numero_conta' => $this->faker->unique()->randomNumber(4),
            'forma_pagamento' => $this->faker->randomElement(['P', 'C', 'D']),
            'valor' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}
