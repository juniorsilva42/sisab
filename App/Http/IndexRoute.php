<?php

namespace App\Http;

final class IndexRoute {

    private static $prototype = [
        '' => [
            'controller' => 'HomeController',
            'action' => 'index'
        ]
    ];

    public static function register () {
        return self::$prototype;
    }
}
