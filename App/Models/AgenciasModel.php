<?php

namespace App\Models;

use PDO;

class AgenciasModel extends \Core\Model {

    private static $db_instance;

    static public function getAll () {
        $db = static::getConnection();

        $sql = 'SELECT * FROM agencias';

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();

            $agenciasList = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $agenciasList;

            $db = null;
        } catch (\PDOException $e) {
            throw new \Exception("Erro model");
        }
    }
}