<?php

namespace App\Http;

final class ClientesRoute {

    private static $prototype = [
            '' => [
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

    public static function register () {
        return self::$prototype;
    }
}
