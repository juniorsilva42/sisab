<?php

namespace App\Models;

use PDO;

class ContasModel extends \Core\Model {

    private static $db_instance;

    public function __construct() {
        $this->db_instance = static::getConnection();
    }

    public static function getAll () {

        $stmt = self::$db_instance->query('SELECT DISTINCT id, nome, numero FROM contas');

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}