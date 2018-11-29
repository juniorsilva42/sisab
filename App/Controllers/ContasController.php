<?php

namespace App\Controllers;

use App\Models\AgenciasModel;
use App\Models\ContasModel;
use App\Sisab\ContaCorrente;
use App\Sisab\ContaEspecial;
use App\Sisab\ContaPoupanca;
use App\Sisab\Exception\ModelException;
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
                    endif;

                } catch (ModelException $e) {
                    $flashMessage = "Erro ao transacionar este saque de R$ ${valor}. Verifique seu saldo e tente novamente mais tarde!";
                    $alert = 'danger';
                }

                break;

            default:
                echo 'Operação inválida!';
        }

        View::renderTemplate('Contas/deposito/index', [
            'flashMessage' => $flashMessage,
            'flashAlert' => $alert,
            'newMessage' => true,
            'quantidade_agencias' => 'undefined'
        ]);
    }
}