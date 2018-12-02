<?php

namespace App\Models;

use App\Sisab\Conta;
use App\Sisab\Exception\EstouroSaldoException;
use App\Sisab\Exception\ModelException;
use PDO;

class ContasModel extends \Core\Model {

    private static $db_instance;

    private static function getDbinstance () {
        try {
            self::$db_instance = static::getConnection();
            return self::$db_instance;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    static public function create (Conta $conta) {

        $sql = 'INSERT INTO contas (numero, saldo, limite, rendimento, tipo, fk_id_agencia) VALUES (?, ?, ?, ?, ?, ?)';

        $condicaoContaEspecial = ($conta->getTipo() == 'CONTA_ESPECIAL') ? $conta->getLimite() : 0;
        $condicaoContaPoupanca = ($conta->getTipo() == 'CONTA_POUPANCA') ? $conta->getRendimento() : 0;

        try {
            $stmt = self::getDbinstance()->prepare($sql);

            $stmt->bindValue(1, $conta->getNumero(), PDO::PARAM_STR);
            $stmt->bindValue(2, $conta->getSaldo(), PDO::PARAM_INT);
            $stmt->bindValue(3, $condicaoContaEspecial , PDO::PARAM_INT);
            $stmt->bindValue(4, $condicaoContaPoupanca, PDO::PARAM_INT);
            $stmt->bindValue(5, $conta->getTipo(), PDO::PARAM_STR);
            $stmt->bindValue(6, $conta->getIdAgencia(), PDO::PARAM_INT);

            return $stmt->execute();

        } catch (\PDOException $e) {
            throw new \PDOException("Erro model");
        }
    }

    static public function getAll () {

        $sql = 'SELECT c.*, a.id_agencia, a.numero_agencia, a.nome_agencia FROM contas c JOIN agencias a ON a.id_agencia = c.fk_id_agencia';

        try {
            $stmt = self::getDbinstance()->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \PDOException("Houve algum erro ao tentar recuperar as contas do sistema. Tente novamente mais tarde.");
        }
    }

    static public function getById ($id_conta) {
        $db = static::getConnection();

        $sql = 'SELECT c.*, a.id_agencia, a.numero_agencia, a.nome_agencia FROM contas c JOIN agencias a ON a.id_agencia = c.fk_id_agencia WHERE c.id = ? LIMIT 1';

        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $id_conta, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_OBJ);

            $db = null;
        } catch (\PDOException $e) {
            throw new \Exception("Erro model");
        }
    }

    static public function delete ($conta_id) {

        $db = static::getConnection();

        $sql = 'DELETE FROM contas WHERE id = ?';

        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $conta_id, PDO::PARAM_INT);

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

    static public function update (Conta $conta) {

        $db = static::getConnection();
        $sql = 'UPDATE contas SET numero = ?, saldo = ?, limite = ? WHERE id = ?';

        $condicaoContaEspecial = ($conta->getTipo() == 'CONTA_ESPECIAL') ? $conta->getLimite() : null;

        try {
            $stmt = $db->prepare($sql);
                $stmt->bindValue(1, $conta->getNumero(), PDO::PARAM_STR);
            $stmt->bindValue(2, $conta->getSaldo(), PDO::PARAM_INT);
            $stmt->bindValue(3, $condicaoContaEspecial, PDO::PARAM_INT);
            $stmt->bindValue(4, $conta->getId(), PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }

            $db = null;
        } catch (\PDOException $e) {
            throw new ModelException("Erro ao atualizar o registro");
        }
    }

    static public function deposito ($id_conta, $valor) {

        $db = static::getConnection();

        $sql1 = 'SELECT saldo FROM contas WHERE id = ? LIMIT 1';
        $sql2 = 'UPDATE contas SET saldo = ? WHERE id = ?';

        try {
            // Obtem o saldo que está na conta no momento
            $stmt1 = $db->prepare($sql1);
            $stmt1->bindValue(1, $id_conta, PDO::PARAM_INT);
            $stmt1->execute();
            $linha = $stmt1->fetch(PDO::FETCH_OBJ);

            // Atualiza o novo saldo
            $stmt2 = $db->prepare($sql2);
            $stmt2->bindValue(1, ($linha->saldo >= 1) ? $linha->saldo + $valor : $valor, PDO::PARAM_INT);
            $stmt2->bindValue(2, $id_conta, PDO::PARAM_INT);

            if ($stmt2->execute()) {
                return true;
            } else {
                return false;
            }

            $db = null;
        } catch (\PDOException $e) {
            throw new \Exception("Erro model");
        }
    }

    static public function saque ($id_conta, $valor) {



        $sql1 = 'SELECT saldo FROM contas WHERE id = ? LIMIT 1';
        $sql2 = 'UPDATE contas SET saldo = ? WHERE id = ?';

        try {
            // Obtem o saldo que está na conta no momento
            $stmt1 = $db->prepare($sql1);
            $stmt1->bindValue(1, $id_conta, PDO::PARAM_INT);
            $stmt1->execute();
            $linha = $stmt1->fetch(PDO::FETCH_OBJ);

            // Verifica se tem valor para saque
            if ($linha->saldo >= $valor) {
                // Atualiza o novo saldo
                $stmt2 = $db->prepare($sql2);
                $stmt2->bindValue(1, $linha->saldo - $valor, PDO::PARAM_INT);
                $stmt2->bindValue(2, $id_conta, PDO::PARAM_INT);

                return $stmt2->execute();

            } else {
                throw new EstouroSaldoException("O seu saldo é insuficiente para transacionar este saque. ");
            }

            $db = null;
        } catch (\PDOException $e) {
            throw new \PDOException("Erro ao tentar fazer a operação no banco de dados, tente novamente mais tarde.");
        }
    }

    static public function transferencia ($id_conta_origem, $id_conta_destino, $valor) {
        try {

            $saque = self::saque($id_conta_origem, $valor);

            if ($saque) {
                $deposito = self::deposito($id_conta_destino, $valor);

                if ($deposito)
                    return true;
            }

            return false;
        } catch (\PDOException $e) {
            throw new \Exception("Erro ao tentar realizar a transferência");
        }
    }
}