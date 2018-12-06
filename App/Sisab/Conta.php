<?php

namespace App\Sisab;

use App\Sisab\Interfaces\ContaInterface;
use App\Sisab\Interfaces\GenericModelInterface;

abstract class Conta implements ContaInterface, GenericModelInterface {

    private $id;
    protected $id_agencia;
    protected $numero;
    protected $saldo;
    protected $tipo;

    public function __construct($numeroConta, $tipo = null) {
        $this->numero = $numeroConta;
        $this->tipo = $tipo;
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

    public function saque ($valor) {
        if ($valor <= $this->saldo) {
            $this->saldo -= $valor;
        } else {

        }
    }

    public function extrato () {
        return "Extrato da conta";
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo)  {
        $this->tipo = $tipo;
    }

    public function getIdAgencia() {
        return $this->id_agencia;
    }

    public function setIdAgencia($id_agencia) {
        return $this->id_agencia = $id_agencia;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }
}