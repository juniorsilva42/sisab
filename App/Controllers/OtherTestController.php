<?php

namespace App\Controllers;

class OtherTestController extends \Core\Controller {

    public function indexAction () {
        // echo ucwords(hash("sha256", "902ef2c77423503981468993d8aec16f.id"));

        echo self::getAction($_SERVER['QUERY_STRING']);
    }

    public static function breakUrl ($url) {
        if ($url != null) {
            $uri = explode('/', $url);
            return $uri;
        }
    }

    public static function getAction ($url) {

        $brokedUrl = self::breakUrl($url);
        $url2 = [];

        if ($brokedUrl != null)
            return $brokedUrl[1];

        return self::getAction($url);
    }
}