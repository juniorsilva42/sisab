<?php

namespace App\Http;

final class ContasRoute {

    private static $prototype = [
        'contas' => [
            'controller' => 'ContasController',
            'action' => 'index'
        ],
        'contas/{id:([a-zA-Z0-9])\w+}' => [
            'controller' => 'HomeController',
            'action' => 'index'
        ]
    ];

    public static function register () {
        return self::$prototype;
    }
}
