<?php

namespace App\Repositories;

use App\Models\Transacao;
use Illuminate\Database\Eloquent\Collection;

class TransacaoRepository
{
    public function all()
    {
        return Transacao::all();
    }

    public function find(int $numero_conta): Collection
    {
        return Transacao::where("numero_conta", $numero_conta)->get();
    }

    public function create(array $data): Transacao
    {
        return Transacao::create($data);
    }
}
