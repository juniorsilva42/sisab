<?php

namespace App\Models;

use App\Sisab\Agencia;
use App\Sisab\Exception\ModelException;
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

    static public function create (Agencia $agencia) {

        $db = static::getConnection();

        $sql = 'INSERT INTO agencias (numero_agencia, nome_agencia, endereco, capacidade) VALUES (?, ?, ?, ?)';

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

    static public function delete ($agencia_id) {

        $db = static::getConnection();

        $sql = 'DELETE FROM agencias WHERE id_agencia = ?';

        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $agencia_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }

            $db = null;
        } catch (\PDOException $e) {
            throw new ModelException("Erro ao deletar o registro");
        }
    }
}