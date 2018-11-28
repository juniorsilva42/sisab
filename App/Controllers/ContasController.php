<?php

namespace App\Controllers;

use App\Models\AgenciasModel;
use App\Models\ContasModel;
use App\Sisab\ContaCorrente;
use App\Sisab\ContaEspecial;
use App\Sisab\ContaPoupanca;
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

        // Seta o estado pro model, onde vai utilizar esses dados para inserir no banco de dados
        $state = ContasModel::create($conta);
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
}