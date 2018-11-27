<?php

namespace App\Models;

use App\Sisab\Agencia;
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

    static public function createNewAgency (Agencia $agencia) {

        $db = static::getConnection();

        $sql = 'INSERT INTO agencias (numero_agencia, nome, endereco, capacidade) VALUES (?, ?, ?, ?)';

        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $agencia->getNumero(), PDO::PARAM_STR);
            $stmt->bindValue(2, $agencia->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(3, $agencia->getEndereco(), PDO::PARAM_STR);
            $stmt->bindValue(4, $agencia->getCapacidade(), PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }

            $db = null;
        } catch (\PDOException $e) {
            throw new \Exception("Erro model");
        }
    }
}