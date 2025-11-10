<?php

namespace App\Services;

use App\Models\Transacao;
use App\Repositories\TransacaoRepository;

class TransacaoService
{
    protected $repository;

    public function __construct(TransacaoRepository $repository) {
        $this->repository = $repository;
    }

    public function buscarExtrato(int $numeroConta)
    {
        return $this->repository->find($numeroConta);
    }

    public function criar(array $data): Transacao
    {
        return $this->repository->create($data);
    }

}
