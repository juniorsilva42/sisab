<?php

namespace App\Sisab;

use App\Sisab\Conta;

final class ContaPoupanca extends Conta {

    private $rendimento;

    public function __construct($numeroConta) {
        parent::__construct($numeroConta);
        $this->rendimento = 3.7;
    }

    public function extrato() {

    }
}