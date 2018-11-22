<?php

namespace Core;

use PDO;
use App\Config\Database;

abstract class Model {

    protected static function getConnection () {

        static $db = null;

        if ($db == null) {
            $uri = 'mysql:host=' . Database::DB_HOST . ';dbname=' . Database::DB_NAME . ';charset=utf8';
            $db = new PDO($uri, Database::DB_PASSWORD);

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }
}