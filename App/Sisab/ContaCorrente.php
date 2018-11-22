<?php

namespace App\Sisab;

use App\Sisab\Conta;
use App\Sisab\Exception\EstouroSaldoException;

final class ContaCorrente extends Conta {

    public function __construct($numConta) {
        parent::__construct($numConta);
    }

    public function saque($valor) {
        if ($valor < $this->saldo) {
            $this->saldo -= $valor;
        }
        throw new EstouroSaldo("Saldo insuficiente");
    }

    public function extrato() {
        return "Numero da Conta Corrente: {$this->numero} - Saldo em conta: {$this->saldo}";
    }
}