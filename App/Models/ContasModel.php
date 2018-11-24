<?php

namespace App\Models;

use PDO;

class ContasModel extends \Core\Model {

    private static $db_instance;

    static public function getAll () {
        $db = static::getConnection();
        $sql = 'SELECT * FROM teste';

        try {
            $stmt = $db->prepare($sql, [PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL]);
            $stmt->execute();

            $contas_list = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $contas_list;

            $stmt = null;
        } catch (\PDOException $e) {
            throw new \Exception("Erro model");
        }
    }
}