<?php

namespace App\Http;

final class ClientesRoute {

    private static $prototype = [
        'clientes' => [
            'controller' => 'ClientesController',
            'action' => 'index'
        ],
        'clientes/{id:([a-zA-Z0-9])\w+}' => [
            'controller' => 'ClientesController',
            'action' => 'getById'
        ]
    ];

    public static function register () {
        return self::$prototype;
    }
}
