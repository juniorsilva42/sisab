<?php

error_reporting(E_ALL);

/*
 *
 * Composer autoload
 * */
require dirname(__DIR__) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

$router = new Core\Router();

$router->iterateRoutes(\App\Http\IndexRoute::register());
$router->iterateRoutes(\App\Http\ClientesRoute::register());
$router->iterateRoutes(\App\Http\ContasRoute::register());

$router->dispatch($_SERVER['QUERY_STRING']);
