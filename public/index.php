<?php

error_reporting(E_ALL);

/*
 *
 * Composer autoload
 * */
require dirname(__DIR__) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

use App\Models\ContasModel;

print_r(ContasModel::getAll());