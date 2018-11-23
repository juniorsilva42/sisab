<?php

error_reporting(E_ALL);

/*
 *
 * Composer autoload
 * */
require dirname(__DIR__) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

$router = new Core\Router();

// Adicionando as rotas
$router->add('', ['controller' => 'HomeController', 'action' => 'index']);

$router->add('posts/', ['controller' => 'OtherTestController', 'action' => 'index']);
$router->add('posts/{id:([a-zA-Z0-9])\w+}', ['controller' => 'OtherTestController', 'action' => 'index']);

$router->dispatch($_SERVER['QUERY_STRING']);