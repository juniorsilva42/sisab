<?php

namespace App\Models;

use PDO;

class Accounts extends \Core\Model {

    public static function getAllAccounts () {

        $db = static::getConnection();
        $stmt = $db->query('SELECT id, nome, tipo FROM contas');

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}