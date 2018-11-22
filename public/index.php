<?php

error_reporting(E_ALL);

/*
 *
 * Composer autoload
 * */
require dirname(__DIR__) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

use App\Sisab\ContaEspecial;

$cc = new ContaEspecial("123556");
$cc->setSaldo(1500);

echo $cc->extrato();