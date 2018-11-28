<?php

namespace App\Http;

final class ContasRoute {

    private static $prototype = [
        'contas' => [
            'controller' => 'ContasController',
            'action' => 'index'
        ],
        'contas/listar' => [
            'controller' => 'ContasController',
            'action' => 'listar'
        ],
        'contas/criar' => [
            'controller' => 'ContasController',
            'action' => 'criar'
        ]
    ];

    public static function register () {
        return self::$prototype;
    }
}
