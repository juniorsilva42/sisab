<?php

error_reporting(E_ALL);

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', dirname(__DIR__));

// Composer autoload
$autoloadFile = ROOT_PATH . DS . "vendor" . DS . "autoload.php";

if (!file_exists($autoloadFile))
    die('O autoload das classes não foi encontrado. <br> Obtenha as dependências utilizando o comando `composer install`');

require $autoloadFile;

$router = new Core\Router();

$router->iterateRoutes(\App\Http\IndexRoute::register());
$router->iterateRoutes(\App\Http\ContasRoute::register());
$router->iterateRoutes(\App\Http\AgenciasRoute::register());
$router->iterateRoutes(\App\Http\ListagemRoute::register());

try {
    $router->dispatch($_SERVER['QUERY_STRING']);
} catch (Exception $e) {
    if ($e->getCode() == '404') {
        \Core\View::renderTemplate('pageNotFound', [
            'message' => $e->getMessage()
        ]);
    }
}

