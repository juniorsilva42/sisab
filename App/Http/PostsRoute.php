<?php

namespace App\Http;

use Core\Router;

final class PostsRoute {

    private $route_prototype = [
        'posts' => [
            'controller' => 'HomeController',
            'action' => 'index'
        ],
        'posts/{id:([a-zA-Z0-9])\w+}' => [
            'controller' => 'postSingleton',
            'action' => 'index'
        ]
    ];

    public static function register () {
        $router = new Router();
        $router->add('', ['controller' => 'HomeController', 'action' => 'index']);
    }
}