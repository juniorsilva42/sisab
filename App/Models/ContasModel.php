<?php

namespace App\Models;

use PDO;

class ContasModel extends \Core\Model {

    private static $db_instance;

    static public function getAll () {
        $db = static::getConnection();

        $sql = 'SELECT c.*, a.id_agencia, a.numero_agencia FROM contas c JOIN agencias a ON a.id_agencia = c.fk_id_agencia';

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