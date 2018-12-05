<?php

namespace App\Models;

use App\Sisab\Exception\EstouroSaldoException;
use App\Sisab\Exception\FormatoNumeroException;
use App\Sisab\Interfaces\ModelsCrudInterface;
use App\Sisab\Interfaces\ModelsInterface;
use PDO;

class ContasModel extends \Core\Model implements ModelsCrudInterface {

    private static $db_instance;

    /**
     *
     * Obtém a instância do banco de dados
     *
     */
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

    static public function create (ModelsInterface $conta) {

        $sql = 'INSERT INTO contas (numero, saldo, limite, rendimento, tipo, fk_id_agencia) VALUES (?, ?, ?, ?, ?, ?)';

        $condicaoContaEspecial = ($conta->getTipo() == 'CONTA_ESPECIAL') ? $conta->getLimite() : 0;
        $condicaoContaPoupanca = ($conta->getTipo() == 'CONTA_POUPANCA') ? $conta->getRendimento() : 0;

        try {
            $stmt = self::getDbinstance()->prepare($sql);

            $numero = str_split($conta->getNumero());

            $quantidadeNumeros = 0;
            $quantidadeLetras = 0;

            foreach ($numero as $numeroPorCaractere) {
                if (is_numeric($numeroPorCaractere)) {
                    $quantidadeNumeros++;
                } else if ($numeroPorCaractere != '-') {
                    $quantidadeLetras++;
                }
            }

            if ($quantidadeLetras >= 3) {
                throw new FormatoNumeroException('A conta não pode conter mais que duas letras!');
            } else if (strlen($conta->getNumero()) < 4 || strlen($conta->getNumero()) >= 10) {
                throw new FormatoNumeroException('A conta deve conter um número entre 4 e 10 caracteres');
            }

            $stmt->bindValue(1, $conta->getNumero(), PDO::PARAM_STR);
            $stmt->bindValue(2, $conta->getSaldo(), PDO::PARAM_INT);
            $stmt->bindValue(3, $condicaoContaEspecial , PDO::PARAM_INT);
            $stmt->bindValue(4, $condicaoContaPoupanca, PDO::PARAM_INT);
            $stmt->bindValue(5, $conta->getTipo(), PDO::PARAM_STR);
            $stmt->bindValue(6, $conta->getIdAgencia(), PDO::PARAM_INT);

            return $stmt->execute();

        } catch (\PDOException $e) {
            throw new \PDOException("OOPS! Houve algum erro ao tentar criar esta conta, tente novamente mais tarde.");
        }
    }

    static public function update (ModelsInterface $conta) {

        $sql = 'UPDATE contas SET numero = ?, limite = ?, rendimento = ?, tipo = ? WHERE id = ?';

        $condicaoContaEspecial = ($conta->getTipo() == 'CONTA_ESPECIAL') ? $conta->getLimite() : NULL;
        $condicaoContaPoupanca = ($conta->getTipo() == 'CONTA_POUPANCA') ? $conta->getRendimento() : NULL;

        try {
            $stmt = self::getDbInstance()->prepare($sql);
            $stmt->bindValue(1, $conta->getNumero(), PDO::PARAM_STR);
            $stmt->bindValue(2, $condicaoContaEspecial, PDO::PARAM_INT);
            $stmt->bindValue(3, $condicaoContaPoupanca, PDO::PARAM_INT);
            $stmt->bindValue(4, $conta->getTipo(), PDO::PARAM_STR);
            $stmt->bindValue(5, $conta->getId(), PDO::PARAM_INT);

            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \PDOException("OOPS! Houve algum erro ao tentar atualizar esta conta, tente novamente mais tarde.");
        }
    }

    static public function getAll () {

        $sql = 'SELECT c.*, a.id AS id_agencia, a.numero AS numero_agencia, a.nome AS nome_agencia FROM contas c JOIN agencias a ON a.id = c.fk_id_agencia';

        try {
            $stmt = self::getDbInstance()->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \PDOException("Houve algum erro ao tentar recuperar as contas do sistema. Tente novamente mais tarde.");
        }
    }

    static public function getById ($id_conta) {

        $sql = 'SELECT c.*, a.id AS id_agencia, a.numero AS numero_agencia, a.nome AS nome_agencia FROM contas c JOIN agencias a ON a.id = c.fk_id_agencia WHERE c.id = ? LIMIT 1';

        try {
            $stmt = self::getDbinstance()->prepare($sql);
            $stmt->bindValue(1, $id_conta, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \PDOException("Houve algum erro ao tentar recuperar esta conta. Tente novamente mais tarde.");
        }
    }

        static public function delete ($conta_id) {

        $sql = 'DELETE FROM contas WHERE id = ?';

        try {
            $stmt = self::getDbInstance()->prepare($sql);
            $stmt->bindValue(1, $conta_id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \PDOException("OOPS! Houve algum erro ao tentar deletar esta conta, tente novamente mais tarde.");
        }
    }

    static public function deposito ($id_conta, $valor) {

        $sql = [
            '1' => 'SELECT saldo FROM contas WHERE id = ? LIMIT 1',
            '2' => 'UPDATE contas SET saldo = ? WHERE id = ?'
        ];

        try {
            // Obtem o saldo que está na conta no momento
            $stmt1 = self::getDbInstance()->prepare($sql['1']);
            $stmt1->bindValue(1, $id_conta, PDO::PARAM_INT);
            $stmt1->execute();
            $linha = $stmt1->fetch(PDO::FETCH_OBJ);

            $valorDeposito = ($linha->saldo >= 1) ? $linha->saldo + $valor : $valor;

            // Atualiza o novo saldo
            $stmt2 = self::getDbInstance()->prepare($sql['2']);
            $stmt2->bindValue(1, $valorDeposito, PDO::PARAM_INT);
            $stmt2->bindValue(2, $id_conta, PDO::PARAM_INT);

            return $stmt2->execute();
        } catch (\PDOException $e) {
            throw new \PDOException("OPS! Houve um erro interno ao transacionar este depósito. Contate o administrador do sistema.");
        }
    }

    static public function saque ($id_conta, $valor) {

        $sql = [
            '1' => 'SELECT saldo FROM contas WHERE id = ? LIMIT 1',
            '2' => 'UPDATE contas SET saldo = ? WHERE id = ?'
        ];

        try {
            // Obtem o saldo que está na conta no momento
            $stmt1 = self::getDbInstance()->prepare($sql['1']);
            $stmt1->bindValue(1, $id_conta, PDO::PARAM_INT);
            $stmt1->execute();
            $linha = $stmt1->fetch(PDO::FETCH_OBJ);

            // Verifica se tem valor para saque
            if ($linha->saldo >= $valor) {
                // Atualiza o novo saldo
                $stmt2 = self::getDbInstance()->prepare($sql['2']);
                $stmt2->bindValue(1, $linha->saldo - $valor, PDO::PARAM_INT);
                $stmt2->bindValue(2, $id_conta, PDO::PARAM_INT);

                return $stmt2->execute();
            } else {
                throw new EstouroSaldoException("Saldo insuficiente para transacionar este saque.");
            }

        } catch (\PDOException $e) {
            throw new \PDOException("OPS! Houve um erro interno ao transacionar este saque. Contate o administrador do sistema.");
        }
    }

    static public function transferencia ($id_conta_origem, $id_conta_destino, $valor) {
        try {

            $saque = self::saque($id_conta_origem, $valor);

            if ($saque) {
                $deposito = self::deposito($id_conta_destino, $valor);

                if ($deposito) return true;
            }

            return false;
        } catch (\PDOException $e) {
            throw new \PDOException("OPS! Houve um erro interno ao transacionar esta transferência. Contate o administrador do sistema.");
        } catch (EstouroSaldoException $e) {
            throw new EstouroSaldoException("O saldo na conta de origem é insuficiente para transacionar esta transferência.");
        }
    }
}