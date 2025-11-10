<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormaPagamento extends Model
{
    protected $table = 'forma_pagamentos';

    protected $fillable = ['forma_pagamento', 'descricao', 'valor_taxa'];

    public function transacoes()
    {
        return $this->hasMany(Transacao::class, 'forma_pagamento');

    }
}
