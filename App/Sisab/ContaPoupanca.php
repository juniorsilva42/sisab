<?php

namespace App\Sisab;

final class ContaPoupanca extends Conta {

    private $rendimento;

    public function __construct($numeroConta) {
        parent::__construct($numeroConta);
        $this->rendimento = 3.7;
    }

    public function extrato() {
        return "Conta Poupança: <br> Numero da Conta: {$this->numero} <br> Saldo: {$this->saldo}";
    }
}