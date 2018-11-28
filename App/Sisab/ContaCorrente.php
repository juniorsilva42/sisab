<?php

namespace App\Sisab;

use App\Sisab\Exception\EstouroSaldoException;

final class ContaCorrente extends Conta {

    public function __construct($numConta, $tipo) {
        parent::__construct($numConta, $tipo);
    }

    public function saque($valor) {
        if ($valor <= $this->saldo) {
            $this->saldo -= $valor;
        } else {
            throw new EstouroSaldoException("Saldo insuficiente");
        }
    }

    public function extrato() {
        return "Conta Corrente: <br> Numero da Conta: {$this->numero} <br> Saldo: {$this->saldo}";
    }
}