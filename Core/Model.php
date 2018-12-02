<?php

namespace Core;

use PDO;
use Config\Database;

abstract class Model {

    protected static function getConnection () {

        static $db = null;

        try {
            if ($db == null) {
                $uri = 'mysql:host=' . Database::DB_HOST . ';dbname=' . Database::DB_NAME . ';charset=utf8';
                $db = new PDO($uri, Database::DB_PASSWORD);

                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        } catch (\PDOException $e) {
            throw new \PDOException("Erro ao tentar conectar-se à base de dados.");
        }

        return $db;
    }
}