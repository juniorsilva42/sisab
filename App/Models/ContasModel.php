<?php

namespace App\Models;

use PDO;

class ContasModel extends \Core\Model {

    private static $db_instance;

    static public function getAll () {
        $db = static::getConnection();

        $stmt = $db->query("SELECT * FROM teste");

        while ($stmt->fetchObject() != null) {
            return $stmt->fetchObject();
        }
    }
}