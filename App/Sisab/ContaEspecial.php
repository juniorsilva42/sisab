<?php

namespace App\Sisab;

use App\Sisab\Exception\EstouroSaldoException;

final class ContaEspecial extends Conta {

    private $limite;

    public function __construct($numConta, $tipo = null, $limite = 1500) {
        parent::__construct($numConta, $tipo);
        $this->limite = $limite;
    }

    public function saque ($valor) {
        if ($valor <= $this->saldo) {
            $this->saldo -= $valor;
        } else if ($valor <= $this->limite + $this->saldo) {
            $valor = $this->saldo;
            $this->limite -= $valor;
            $this->saldo = 0;
        } else {
            throw new EstouroSaldoException("Saldo insuficiente");
        }
    }

    public function extrato() {
        return "Conta Especial: <br> Numero da Conta: {$this->numero} <br> Saldo: {$this->saldo} <br> Limite: {$this->limite}";
    }

    /**
     * @return int
     */
    public function getLimite()
    {
        return $this->limite;
    }
}