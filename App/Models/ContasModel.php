<?php

namespace App\Models;

use PDO;

class ContasModel extends \Core\Model {

    private $db_instance;

    public function __construct() {
        $this->db_instance = static::getConnection();
    }

    public function getAllAccounts () {

        $stmt = $this->db_instance->query('SELECT id, nome, numero FROM contas');

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}