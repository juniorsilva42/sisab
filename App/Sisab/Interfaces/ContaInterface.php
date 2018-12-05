<?php

namespace App\Sisab\Interfaces;

interface ContaInterface {

    public function saque($valor);

    public function deposito($valor);
}