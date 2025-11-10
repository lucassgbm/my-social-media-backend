<?php

namespace Tests\Feature;

use App\Models\Conta;
use App\Models\FormaPagamento;
use App\Models\Transacao;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransacaoFeatureTest extends TestCase
{
    public function test_realizar_uma_transacao()
    {

        $numero_conta = random_int(1000,9999);

        $conta = Conta::factory()->create([
            'numero_conta' => $numero_conta,
            'saldo' => 100.00,
        ]);

        $payload = [
            "numero_conta" => $numero_conta,
            "forma_pagamento" => "D", // D = Débito
            "valor" => 65
        ];

        $formaPagamento = FormaPagamento::where('forma_pagamento', $payload['forma_pagamento'])->first();

        $valorTransacao = $payload['valor'] + ($payload['valor'] * $formaPagamento->valor_taxa / 100);

        $response = $this->postJson('/api/transacao', $payload);

        $saldo = $conta->saldo - $valorTransacao;

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'numero_conta' => $numero_conta,
                     'saldo' => $saldo
                 ]);

    }

    public function test_realizar_uma_transacao_com_saldo_insuficiente()
    {

        $numero_conta = random_int(1000,9999);

        Conta::factory()->create([
            'numero_conta' => $numero_conta,
            'saldo' => 100.00,
        ]);

        $payload = [
            "numero_conta" => $numero_conta,
            "forma_pagamento" => "D", // D = Débito
            "valor" => 100
        ];

        $response = $this->postJson('/api/transacao', $payload);

        $response->assertStatus(404)
        ->assertJsonFragment([
            'message' => 'O saldo da conta é insuficiente'
        ]);

    }


    public function test_consultar_extrato()
    {

        $numero_conta = random_int(1000,9999);

        Conta::factory()->create([
            'numero_conta' => $numero_conta,
            'saldo' => 100.00,
        ]);

        Transacao::factory()->create([
            'numero_conta' => $numero_conta,
            'forma_pagamento' => "D",
            'valor' => 10
        ]);

        Transacao::factory()->create([
            'numero_conta' => $numero_conta,
            'forma_pagamento' => "C",
            'valor' => 20
        ]);


        $response = $this->getJson('/api/transacao/?numero_conta='.$numero_conta);
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');

    }

    public function test_consultar_extrato_vazio()
    {
        $numero_conta = random_int(1000,9999);

        Conta::factory()->create([
            'numero_conta' => $numero_conta,
            'saldo' => 100.00,
        ]);

        $response = $this->getJson('/api/transacao/?numero_conta='.$numero_conta);
        $response->assertStatus(404);
        $response->assertJsonFragment([
            'message' => 'Extrato vazio'
        ]);
    }

    public function test_consultar_extrato_sem_numero_da_conta()
    {

        $response = $this->getJson('/api/transacao/?numero_conta');
        $response->assertStatus(400);
        $response->assertJsonFragment([
            'message' => 'Número da conta não informado'
        ]);
    }
}
