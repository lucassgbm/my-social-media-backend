<?php
namespace App\Services;

use App\Repositories\ContaRepository;

class ContaService
{
    protected $repository;

    public function __construct(ContaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function buscarConta(int $numeroConta)
    {
        return $this->repository->find($numeroConta);
    }

    public function criarConta(array $data)
    {
        return $this->repository->create($data);
    }

    public function atualizarSaldo(int $numeroConta, float $valor)
    {
        return $this->repository->updateSaldo($numeroConta, $valor);
    }

}
