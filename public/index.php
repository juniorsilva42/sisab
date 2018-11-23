<?php

error_reporting(E_ALL);

/*
 *
 * Composer autoload
 * */
require dirname(__DIR__) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

use App\Models\ContasModel;

$contasModel = new ContasModel();

foreach($contasModel::getAll() as $key => $value) {
    echo $key . "-" . $value . "<br/>";
}