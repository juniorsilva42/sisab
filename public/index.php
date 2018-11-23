<?php

error_reporting(E_ALL);

/*
 *
 * Composer autoload
 * */
require dirname(__DIR__) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

$router = new Core\Router();

/**
$router->add('', ['controller' => 'HomeController', 'action' => 'index']);

$router->add('posts/', ['controller' => 'OtherTestController', 'action' => 'index']);
$router->add('posts/{id:([a-zA-Z0-9])\w+}', ['controller' => 'OtherTestController', 'action' => 'index']);

$router->dispatch($_SERVER['QUERY_STRING']);
 * */

$route_prototype = [
    '' => [
      'controller' => 'HomeController',
      'action' => 'index'
    ],
    'posts/' => [
        'controller' => 'HomeController',
        'action' => 'index'
    ],
    'clientes' => [
        'controller' => 'HomeController',
        'action' => 'index'
    ],
    'clientes/{id:([a-zA-Z0-9])\w+}' => [
        'controller' => 'HomeController',
        'action' => 'index'
    ]
];

$route_prototype2 = [
    'test' => [
        'controller' => 'HomeController',
        'action' => 'index'
    ]
];

$router->iterateRoutes($route_prototype);
$router->iterateRoutes($route_prototype2);
$router->dispatch($_SERVER['QUERY_STRING']);
