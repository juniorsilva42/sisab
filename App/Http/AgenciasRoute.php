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
        ],
        'agencias/criar' => [
            'controller' => 'AgenciasController',
            'action' => 'criar'
        ],
        'agencias/deletar/{id:([0-9]+)}' => [
            'controller' => 'AgenciasController',
            'action' => 'deletar'
        ]
    ];

    public static function register () {
        return self::$prototype;
    }
}
