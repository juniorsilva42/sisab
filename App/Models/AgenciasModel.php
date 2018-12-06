<?php

namespace App\Models;

use App\Sisab\Interfaces\ModelsInterface;
use App\Sisab\Interfaces\GenericModelInterface;
use PDO;

class AgenciasModel extends \Core\Model implements ModelsInterface {

    private static $db_instance;

    private static function getDbInstance () {
        try {
            self::$db_instance = static::getConnection();
            return self::$db_instance;
        } catch (\PDOException $e) {
            die($e->getMessage());
        } finally {
            self::$db_instance = null;
        }
    }

    static public function create (GenericModelInterface $agencia) {
        $sql = 'INSERT INTO agencias (numero, nome, endereco, capacidade) VALUES (?, ?, ?, ?)';

        try {
            $stmt = self::getDbinstance()->prepare($sql);
            $stmt->bindValue(1, $agencia->getNumero(), PDO::PARAM_STR);
            $stmt->bindValue(2, $agencia->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(3, $agencia->getEndereco(), PDO::PARAM_STR);
            $stmt->bindValue(4, $agencia->getCapacidade(), PDO::PARAM_INT);

            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \PDOException("OOPS! Houve algum erro ao tentar criar esta agência, tente novamente mais tarde.");
        }
    }

    /**
     *
     * Obtém todas agências
     *
     * */
    static public function getAll () {

        $sql = 'SELECT * FROM agencias ORDER BY numero ASC';

        try {
            $stmt = self::getDbInstance()->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \PDOException("Houve algum erro ao tentar recuperar as agências do sistema. Tente novamente mais tarde.");
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
            throw new \Exception("Houve algum erro ao tentar recuperar esta agência. Tente novamente mais tarde.");
        }
    }

    static public function delete ($agencia_id) {

        $sql = 'DELETE FROM agencias WHERE id = ?';

        try {
            $stmt = self::getDbinstance()->prepare($sql);
            $stmt->bindValue(1, $agencia_id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new ModelException("OOPS! Houve algum erro ao tentar deletar esta agência, tente novamente mais tarde.");
        }
    }

    static public function update (GenericModelInterface $agencia) {

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
            throw new \PDOException("OOPS! Houve algum erro ao tentar atualizar esta agência, tente novamente mais tarde.");
        }
    }
}