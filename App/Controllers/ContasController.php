<?php

namespace App\Controllers;

use App\Models\AgenciasModel;
use App\Models\ContasModel;
use App\Sisab\ContaCorrente;
use App\Sisab\ContaEspecial;
use App\Sisab\ContaPoupanca;
use App\Sisab\Exception\ModelException;
use Core\Util\HttpHelpers;
use Core\View;

class ContasController extends \Core\Controller {

    public function indexAction () {
        $agencias = AgenciasModel::getAll();

        View::renderTemplate('Contas/index', [
            'agencias' => $agencias
        ]);
    }

    public function listar () {

       $contas = ContasModel::getAll();

        View::renderTemplate('Contas/listar', [
            'contas' => $contas,
            'quantidade' => count($contas)
        ]);
    }

    public function criarAction () {

        // Obtem os dados do formulário pela Query String do Request
        $numero = ($_REQUEST['numero']) ? $_REQUEST['numero'] : null;
        $limite = ($_REQUEST['limite']) ? $_REQUEST['limite'] : 0;
        $rendimento = ($_REQUEST['rendimento']) ? $_REQUEST['rendimento'] : 0;
        $tipo = ($_REQUEST['tipo']) ? $_REQUEST['tipo'] : 'CONTA_POUPANCA';
        $id_agencia = ($_REQUEST['agencia']) ? $_REQUEST['agencia'] : 0;

        switch ($tipo) {
            case 'CONTA_POUPANCA':
                $conta = new ContaPoupanca($numero, $tipo, $id_agencia, $rendimento);
                break;

            case 'CONTA_CORRENTE':
                $conta = new ContaCorrente($numero, $tipo, $id_agencia);
                break;

            case 'CONTA_ESPECIAL':
                $conta = new ContaEspecial($numero, $tipo, $id_agencia, $limite);
                break;

            default:
                $conta = new ContaPoupanca($numero, $tipo, $id_agencia, $rendimento);
                $tipo = 'CONTA_POUPANCA';
        }

        try {
            $state = ContasModel::create($conta);

            // Controle as flash messages baseado no retorno do Model
            if ($state):
                $flashMessage = 'A conta foi criada com sucesso!';
                $alert = 'success';
            endif;

        } catch (ModelException $e) {
            $flashMessage = "OPA! Houve algum erro ao criar a conta";
            $alert = 'danger';
        }

        // Renderiza o template implantando as variáveis de controle
        View::renderTemplate('Contas/index', [
            'flashMessage' => $flashMessage,
            'flashAlert' => $alert,
            'newMessage' => true,
            'quantidade_agencias' => 'undefined'
        ]);
    }

    public function deletarAction () {

        $id_conta = HttpHelpers::getId($_SERVER['QUERY_STRING']);

        try {
            $state = ContasModel::delete($id_conta);

            // Controle as flash messages baseado no retorno do Model
            if ($state):
                $flashMessage = 'A conta foi deletada com sucesso!';
                $alert = 'success';
            endif;

        } catch (ModelException $e) {
            $flashMessage = "OPA! Houve algum erro ao deletar a conta.";
            $alert = 'danger';
        }

        // Renderiza o template implantando as variáveis de controle
        View::renderTemplate('Contas/listar', [
            'flashMessage' => $flashMessage,
            'flashAlert' => $alert,
            'newMessage' => true,
            'quantidade_contas' => 'undefined'
        ]);
    }

    public function editarAction () {

        // Obtem os dados do formulário pela Query String do Request
        $id_conta = (isset($_REQUEST['cid'])) ? $_REQUEST['cid'] : null;
        $numero = (isset($_REQUEST['numero'])) ? $_REQUEST['numero'] : null;
        $saldo = (isset($_REQUEST['saldo'])) ? $_REQUEST['saldo'] : null;
        $limite = (isset($_REQUEST['limite'])) ? $_REQUEST['limite'] : null;
        $rendimento = (isset($_REQUEST['rendimento'])) ? $_REQUEST['rendimento'] : null;
        $tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : null;

        $sign = (isset($_REQUEST['sign'])) ? $_REQUEST['sign'] : null;

        if (!isset($sign) || $sign != 'do') {
            View::renderTemplate("Contas/editar", [
                'id_conta' => $id_conta,
                'numero' => $numero,
                'saldo' => $saldo,
                'limite' => $limite,
                'rendimento' => $rendimento,
                'tipo' => $tipo
            ]);
        } else {

            $conta = new ContaCorrente();
            $conta->setNumero($numero);
            $conta->setSaldo($saldo);
            $conta->setTipo($tipo);
            $conta->setId($id_conta);

            try {

                $state = ContasModel::editar($conta);

                // Controle as flash messages baseado no retorno do Model
                if ($state):
                    $flashMessage = 'A agência foi atualizada com sucesso!';
                    $alert = 'success';
                else:
                    $flashMessage = 'OPA! Houve algum erro ao atualizar à agência!';
                    $alert = 'danger';
                endif;

                View::renderTemplate("Agencias/editar", [
                    'flashMessage' => $flashMessage,
                    'flashAlert' => $alert,
                    'newMessage' => true
                ]);

            } catch (ModelException $e) {}

        }
    }

    public function depositoAction () {
        $contas = ContasModel::getAll();

        View::renderTemplate('Contas/deposito/index', [
            'contas' => $contas
        ]);
    }

    public function transferenciaAction () {
        $contas = ContasModel::getAll();

        View::renderTemplate('Contas/transferencia/index', [
            'contas' => $contas
        ]);
    }

    public function saqueAction () {
        $contas = ContasModel::getAll();

        View::renderTemplate('Contas/saque/index', [
            'contas' => $contas
        ]);
    }

    public function extratoAction () {

        $id = HttpHelpers::getId($_SERVER['QUERY_STRING']);
        $conta = ContasModel::getById($id);

        View::renderTemplate('Extrato/index', [
            'conta' => $conta
        ]);
    }

    public function operacaoAction () {

        // Obtem os dados do formulário pela Query String do Request
        $agencia = (isset($_REQUEST['agencia'])) ? $_REQUEST['agencia'] : false;
        $id_conta = (isset($_REQUEST['conta'])) ? $_REQUEST['conta'] : null;
        $valor = (isset($_REQUEST['valor'])) ? $_REQUEST['valor'] : 0;
        $operacao = (isset($_REQUEST['operacao'])) ? $_REQUEST['operacao'] : 0;

        switch ($operacao) {

            case 'deposito':

                try {
                    $state = ContasModel::deposito($id_conta, $valor);

                    // Controle as flash messages baseado no retorno do Model
                    if ($state):
                        $flashMessage = "O depósito de R$ ${valor} foi transacionado com sucesso!";
                        $alert = 'success';
                    endif;

                } catch (ModelException $e) {
                    $flashMessage = "Erro ao transacionar este depósito de R$ ${valor}. Tente novamente mais tarde!";
                    $alert = 'danger';
                }

                break;

            case 'saque':

                try {
                    $state = ContasModel::saque($id_conta, $valor);

                    // Controle as flash messages baseado no retorno do Model
                    if ($state):
                        $flashMessage = "O saque de R$ ${valor} foi transacionado com sucesso!";
                        $alert = 'success';
                    else:
                        $flashMessage = "Erro ao transacionar este saque de R$ ${valor}. Verifique seu saldo e tente novamente mais tarde!";
                        $alert = 'danger';
                    endif;

                } catch (\PDOException $e) {
                    $flashMessage = "Erro ao transacionar este saque de R$ ${valor}. Verifique seu saldo e tente novamente mais tarde!";
                    $alert = 'danger';
                }

                break;

            default:
                echo 'Operação inválida!';
        }

        if ($operacao == 'deposito') {
            $view = 'Contas/deposito/index';
        } else if ($operacao == 'saque') {
            $view = 'Contas/saque/index';
        }

        View::renderTemplate($view, [
            'flashMessage' => $flashMessage,
            'flashAlert' => $alert,
            'newMessage' => true,
            'tipo' => 'operacao',
            'operacao' => $operacao,
            'id_conta' => $id_conta,
            'quantidade_agencias' => 'undefined'
        ]);
    }
}