<?php

namespace Core\Util;

final class HttpHelpers {

    public static function breakUrl ($url) {
        if ($url != null) {
            $uri = explode('/', $url);
            return $uri;
        }
    }

    public static function getRestrictionId ($url) {

        $brokedUrl = self::breakUrl($url);

        if ($brokedUrl != null && isset($brokedUrl[1]))
            return $brokedUrl[1];

        return self::getRestrictionId($url);
    }


    public static function getAction ($url) {

        $brokedUrl = self::breakUrl($url);

        if ($brokedUrl != null && isset($brokedUrl[0]))
            return $brokedUrl[0];

        return self::getAction($url);
    }
}