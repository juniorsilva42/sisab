<?php

namespace Util;

final class HttpHelpers {

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