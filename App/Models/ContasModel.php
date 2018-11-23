<?php

namespace App\Models;

use PDO;

class ContasModel extends \Core\Model {

    private static $db_instance;

    public function __construct () {
        self::$db_instance = static::getConnection();
    }

    static public function getAll () {
        $stmt = self::$db_instance->query("SELECT * FROM teste");
        return $stmt->fetch(PDO::FETCH_ASSOC); // self::$db_instance
    }
}