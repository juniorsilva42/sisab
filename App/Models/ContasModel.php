<?php

namespace App\Models;

use App\Sisab\Conta;
use PDO;

class ContasModel extends \Core\Model {

    private static $db_instance;

    static public function getAll () {
        $db = static::getConnection();

        $sql = 'SELECT c.*, a.id_agencia, a.numero_agencia, a.nome_agencia FROM contas c JOIN agencias a ON a.id_agencia = c.fk_id_agencia';

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

    static public function create (Conta $conta) {

        $db = static::getConnection();

        $sql = 'INSERT INTO contas (numero, saldo, limite, rendimento, tipo, fk_id_agencia) VALUES (?, ?, ?, ?, ?, ?)';

        $condicaoEspecial = ($conta->getTipo() == 'CONTA_ESPECIAL') ? $conta->getLimite() : null;
        $condicaoCorrente = ($conta->getTipo() == 'CONTA_POUPANCA') ? $conta->getRendimento() : null;

        try {
            $stmt = $db->prepare($sql);

            $stmt->bindValue(1, $conta->getNumero(), PDO::PARAM_STR);
            $stmt->bindValue(2, $conta->getSaldo(), PDO::PARAM_INT);
            $stmt->bindValue(3, $condicaoEspecial , PDO::PARAM_INT);
            $stmt->bindValue(4, $condicaoCorrente, PDO::PARAM_INT);
            $stmt->bindValue(5, $conta->getTipo(), PDO::PARAM_STR);
            $stmt->bindValue(6, $conta->getIdAgencia(), PDO::PARAM_INT);

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