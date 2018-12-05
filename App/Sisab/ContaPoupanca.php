<?php

namespace App\Sisab;

use App\Sisab\Interfaces\ModelsInterface;

final class ContaPoupanca extends Conta implements ModelsInterface {

    private $rendimento;

    public function __construct($numeroConta = null, $tipo, $rendimento = 5) {
        parent::__construct($numeroConta, $tipo);
        $this->rendimento = $rendimento;
        $this->saldo += ($this->rendimento * $this->saldo) / 100;
    }

    public function extrato() {
        return "Conta Poupança: <br> Numero da Conta: {$this->numero} <br> Saldo: {$this->saldo}";
    }

    public function getRendimento()
    {
        return $this->rendimento;
    }
}