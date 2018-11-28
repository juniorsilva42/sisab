<?php

namespace App\Sisab\Interfaces;

interface ContaInterface {

    function saque($valor);

    function deposito($valor);

    function extrato();
}