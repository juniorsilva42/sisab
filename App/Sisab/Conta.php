<?php

namespace App\Sisab;

abstract class Conta {

    protected $numero;
    protected $saldo;

    public function __construct($numeroConta) {
        $this->numero = $numeroConta;
        $this->saldo = 0;
    }


}