<?php

namespace App\Sisab\Interfaces;

interface ContaInterface {

    function saque($valor);

    function deposito(Conta $conta, $valor);

    function extrato();
}