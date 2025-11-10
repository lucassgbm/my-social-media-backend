<?php

namespace App\Services;

use App\Models\FormaPagamento;
use App\Repositories\FormaPagamentoRepository;

class FormaPagamentoService
{
    protected $repository;

    public function __construct(FormaPagamentoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listar()
    {
        return $this->repository->all();
    }

    public function buscar(string $formaPagamento)
    {
        return $this->repository->find($formaPagamento);
    }

}
