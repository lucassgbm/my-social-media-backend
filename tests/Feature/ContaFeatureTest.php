<?php

namespace Tests\Feature;

use App\Models\Conta;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContaFeatureTest extends TestCase
{
    // use RefreshDatabase;

    public function test_cadastrar_conta()
    {
        $user = User::factory()->create([
            'name' => fake()->name()
        ]);

        $numero_conta = random_int(1000,9999);
        $payload = [
            'numero_conta' => $numero_conta,
            'user_id' => $user->id,
            'saldo' => "1000.00",
        ];

        $response = $this->postJson('api/conta', $payload);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'numero_conta' => $numero_conta,
            'saldo' => "1000.00",
        ]);

        $this->assertDatabaseHas('contas', $payload);
    }

    public function test_retornar_dados_da_conta()
    {

        $user = User::factory()->create();
        $numero_conta = random_int(1000,9999);

        Conta::factory()->create([
            'numero_conta' => $numero_conta,
            'user_id' => $user->id,
            'saldo' => 500.00
        ]);


        $response = $this->getJson('/api/conta/?numero_conta='.$numero_conta);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'numero_conta' => $numero_conta,
            'saldo' => 500.00,
        ]);
    }


    public function test_numero_da_conta_nao_informado()
    {
        $response = $this->getJson('/api/conta');
        $response->assertStatus(400);
        $response->assertJsonFragment([
            'message' => 'Número da conta não informado'
        ]);
    }

    public function test_conta_nao_encontrada()
    {
        $response = $this->getJson('/api/conta/?numero_conta=300000');
        $response->assertStatus(404);
        $response->assertJsonFragment([
            'message' => 'Conta não encontrada'
        ]);
    }
}
