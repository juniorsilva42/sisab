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
        ],
        'contas/deletar/{id:([0-9]+)}' => [
            'controller' => 'ContasController',
            'action' => 'deletar'
        ],
        'contas/editar' => [
            'controller' => 'ContasController',
            'action' => 'editar'
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
        return self::$prototype;
    }
}
