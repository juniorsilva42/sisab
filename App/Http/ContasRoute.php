<?php

namespace App\Http;

final class ContasRoute {

    /**
     *
     * Rotas que dispacham e operam o CRUD
     * */
    private static $crud_way = [
        'contas/listar' => [
            'controller' => 'ContasController',
            'action' => 'listar'
        ],
        'contas/criar' => [
            'controller' => 'ContasController',
            'action' => 'criar'
        ],
        'contas/deletar/{id:([0-9]+)}' => [
            'controller' => 'ContasController',
            'action' => 'deletar'
        ],
        'contas/editar' => [
            'controller' => 'ContasController',
            'action' => 'editar'
        ]
    ];

    /**
     *
     * Rotas que dispacham as outras rotas de contas: deposito, transferencia, saque e etc
     * */
    private static $default_way = [
        'contas' => [
            'controller' => 'ContasController',
            'action' => 'index'
        ],
        'contas/deposito' => [
            'controller' => 'ContasController',
            'action' => 'deposito'
        ],
        'contas/transferencia' => [
            'controller' => 'ContasController',
            'action' => 'transferencia'
        ],
        'contas/saque' => [
            'controller' => 'ContasController',
            'action' => 'saque'
        ],
        'contas/operacao' => [
            'controller' => 'ContasController',
            'action' => 'operacao'
        ],
        'contas/extrato/{id:([0-9]+)}' => [
            'controller' => 'ContasController',
            'action' => 'extrato'
        ]
    ];

    public static function register () {
        return array_merge(self::$crud_way, self::$default_way);
    }
}
