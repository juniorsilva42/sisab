<?php

namespace App\Models;

use PDO;

class ContasModel extends \Core\Model {

    private static $db_instance;

    static public function getAll () {
        $db = static::getConnection();
        $sql = 'SELECT * FROM teste';

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();

            $contas_list = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $contas_list;

        } catch (\PDOException $e) {
            throw new \Exception("Erro model");
        }
    }
}