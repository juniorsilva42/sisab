<?php

namespace App\Http;

final class AgenciasRoute {

    private static $default_way = [
        'agencias' => [
            'controller' => 'AgenciasController',
            'action' => 'index'
        ]
    ];

    private static $crud_way = [
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
        ],
        'agencias/editar' => [
            'controller' => 'AgenciasController',
            'action' => 'editar'
        ]
    ];

    public static function register () {
        return array_merge(self::$crud_way, self::$default_way);
    }
}
