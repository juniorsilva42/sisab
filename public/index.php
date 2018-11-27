<?php

error_reporting(E_ALL);

/*
 *
 * Composer autoload
 * */
$autoloadFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

require $autoloadFile;

if (!file_exists($autoloadFile))
    die('O autoload das classes não foi encontrado. <br> Obtenha as dependências utilizando o comando `composer install`');

$router = new Core\Router();

$router->iterateRoutes(\App\Http\IndexRoute::register());
$router->iterateRoutes(\App\Http\ClientesRoute::register());
$router->iterateRoutes(\App\Http\ContasRoute::register());

$router->dispatch($_SERVER['QUERY_STRING']);

