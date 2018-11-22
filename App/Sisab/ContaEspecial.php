<?php

namespace App\Sisab;

use App\Sisab\Exception\EstouroSaldoException;

final class ContaEspecial extends Conta {

    private $limite;

    public function __construct($numConta) {
        parent::__construct($numConta);
        $this->limite = 1500;
    }

    public function ContaEspecial ($numConta, $valorLimite) {
        parent::ContaEspecial($numConta);
        $limite = $valorLimite;
    }

    public function extrato() {}

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
}