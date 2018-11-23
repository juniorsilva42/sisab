<?php

error_reporting(E_ALL);

/*
 *
 * Composer autoload
 * */
require dirname(__DIR__) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

$router = new Core\Router();

// Adicionando as rotas
$router->add('', ['controller' => 'Home', 'action' => 'index']);