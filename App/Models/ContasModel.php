<?php

namespace App\Models;

use PDO;

class ContasModel extends \Core\Model {

    private static $db_instance;

    static public function getAll () {
        $db = static::getConnection();

        $sql = 'SELECT * FROM contas';

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();

            $contas_list = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $contas_list;

            $db = null;
        } catch (\PDOException $e) {
            throw new \Exception("Erro model");
        }
    }
}