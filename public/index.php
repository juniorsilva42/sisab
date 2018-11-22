<?php

error_reporting(E_ALL);

// Composer autoload
require dirname(__DIR__) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

use App\Sisab\ContaCorrente;
use \App\Sisab\Agencia;

$agencia = new Agencia("2133-x");
$conta = new ContaCorrente("12345");

$conta->setSaldo(1200);

echo 'Número: ' . $conta->getNumero() . '<br>';
echo 'Saldo: ' . $conta->getSaldo();

$conta->saque(500);

echo 'Saldo: ' . $conta->getSaldo();


$conta->saque(700);

echo 'Saldo: ' . $conta->getSaldo();

