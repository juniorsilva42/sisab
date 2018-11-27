<?php

namespace App\Http;

final class AgenciasRoute {

    private static $prototype = [
        'agencias' => [
            'controller' => 'AgenciasController',
            'action' => 'index'
        ]
    ];

    public static function register () {
        return self::$prototype;
    }
}
