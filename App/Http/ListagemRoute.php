<?php

namespace App\Http;

final class ListagemRoute {

    private static $prototype = [
        'listagem' => [
            'controller' => 'ListagemController',
            'action' => 'index'
        ]
    ];

    public static function register () {
        return self::$prototype;
    }
}
