<?php

namespace App\Models;

use PDO;

class ContasModel extends \Core\Model {

    private static $db_instance;

    public function __construct() {
        $this->db_instance = static::getConnection();
    }

    public static function getAll () {
        $db = static::getConnection();
        $stmt = $db->query('SELECT * FROM teste');

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}