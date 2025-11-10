<?php

namespace App\Repositories;

use App\Models\FormaPagamento;

class FormaPagamentoRepository
{
    public function all()
    {
        return FormaPagamento::all();
    }

    public function find(string $forma_pagamento): ?FormaPagamento
    {
        return FormaPagamento::where('forma_pagamento', $forma_pagamento)->first();
    }

}
