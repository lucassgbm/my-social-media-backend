<?php

namespace App\Repositories;

use App\Models\Conta;

class ContaRepository
{

    public function find(int $numero_conta)
    {
        return Conta::where('numero_conta', $numero_conta)->first();
    }

    public function create(array $data)
    {
        return Conta::create($data);
    }

    public function updateSaldo(int $numero_conta, float $saldo)
    {
        return Conta::where('numero_conta', $numero_conta)
        ->update(['saldo' => $saldo]);
    }

}
