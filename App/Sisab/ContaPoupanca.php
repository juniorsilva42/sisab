<?php

namespace App\Sisab;

final class ContaPoupanca extends Conta {

    private $rendimento;

    public function __construct($numeroConta, $tipo, $rendimento = 5) {
        parent::__construct($numeroConta, $tipo);
        $this->rendimento = $rendimento;
    }

    public function extrato() {
        return "Conta Poupança: <br> Numero da Conta: {$this->numero} <br> Saldo: {$this->saldo}";
    }
}