<?php

namespace App\Sisab;

use App\Sisab\Interfaces\ContaInterface;

abstract class Conta implements ContaInterface {

    protected $numero;
    protected $saldo;
    protected $cliente;

    public function __construct($numeroConta) {
        $this->numero = $numeroConta;
        $this->saldo = 0;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function getSaldo() {
        return $this->saldo;
    }

    public function setSaldo($saldo) {
        $this->saldo = $saldo;
    }

    public final function deposito ($valor) {
        $this->saldo += $valor;
    }

    public function saque($valor) {
        if ($valor <= $this->saldo) {
            $this->saldo -= $valor;
        } else {
            throw new EstouroSaldoException("Saldo insuficiente");
        }
    }

    public function extrato () {
        return "Extrato da conta";
    }
}