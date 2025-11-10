<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conta>
 */
class ContaFactory extends Factory
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
            'user_id' => \App\Models\User::factory(),
            'saldo' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}
