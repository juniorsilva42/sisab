<?php

namespace App\Models;

use App\Sisab\Agencia;
use App\Sisab\Exception\ModelException;
use PDO;

class AgenciasModel extends \Core\Model {

    private static $db_instance;

    private static function getDbinstance () {
        try {
            self::$db_instance = static::getConnection();
            return self::$db_instance;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     *
     * Obtém todas agências
     *
     * */
    static public function getAll () {

        $sql = 'SELECT * FROM agencias';

        $db = static::getConnection();

        try {
            $stmt = $db->prepare($sql);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception("Erro model");
        }
    }

    static public function getById ($id_agencia) {

        $sql = 'SELECT * FROM agencias WHERE id = ? LIMIT 1';

        try {
            $stmt = self::getDbinstance()->prepare($sql);
            $stmt->bindValue(1, $id_agencia, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception("Erro model");
        }
    }

    static public function create (Agencia $agencia) {
        $sql = 'INSERT INTO agencias (numero, nome, endereco, capacidade) VALUES (?, ?, ?, ?)';

        try {
            $stmt = self::getDbinstance()->prepare($sql);
            $stmt->bindValue(1, $agencia->getNumero(), PDO::PARAM_STR);
            $stmt->bindValue(2, $agencia->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(3, $agencia->getEndereco(), PDO::PARAM_STR);
            $stmt->bindValue(4, $agencia->getCapacidade(), PDO::PARAM_INT);

            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Erro model");
        }
    }

    static public function delete ($agencia_id) {

        $sql = 'DELETE FROM agencias WHERE id = ?';

        try {
            $stmt = self::getDbinstance()->prepare($sql);
            $stmt->bindValue(1, $agencia_id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new ModelException("Erro ao deletar o registro");
        }
    }

    static public function editar (Agencia $agencia) {

        $sql = 'UPDATE agencias SET numero = ?, nome = ?, endereco = ?, capacidade = ? WHERE id = ?';

        try {
            $stmt = self::getDbinstance()->prepare($sql);
            $stmt->bindValue(1, $agencia->getNumero(), PDO::PARAM_STR);
            $stmt->bindValue(2, $agencia->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(3, $agencia->getEndereco(), PDO::PARAM_STR);
            $stmt->bindValue(4, $agencia->getCapacidade(), PDO::PARAM_INT);
            $stmt->bindValue(5, $agencia->getId(), PDO::PARAM_INT);

            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new ModelException("Erro ao atualizar o registro");
        }
    }
}