<?php

namespace App\Http;

final class AgenciasRoute {

    private static $prototype = [
        'agencias' => [
            'controller' => 'AgenciasController',
            'action' => 'index'
        ],
        'agencias/listar' => [
            'controller' => 'AgenciasController',
            'action' => 'listar'
        ]
    ];

    public static function register () {
        return self::$prototype;
    }
}
