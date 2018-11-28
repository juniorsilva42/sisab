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
            'contas' => $contas
        ]);
    }

    public function criarAction () {

        // Obtem os dados do formulário pela Query String do Request
        $numero = ($_REQUEST['numero']) ? $_REQUEST['numero'] : false;
        $limite = ($_REQUEST['limite']) ? $_REQUEST['limite'] : 1500;
        $rendimento = ($_REQUEST['rendimento']) ? $_REQUEST['rendimento'] : 0;
        $tipo = ($_REQUEST['tipo']) ? $_REQUEST['tipo'] : 'CONTA_POUPANCA';
        $agencia = ($_REQUEST['agencia']) ? $_REQUEST['agencia'] : false;

        switch ($tipo) {
            case 'CONTA_POUPANCA':

                $conta = new ContaPoupanca($numero, $tipo, $rendimento);

                break;

            case 'CONTA_CORRENTE':

                $conta = new ContaCorrente($numero, $tipo);

                break;

            case 'CONTA_ESPECIAL':

                $conta = new ContaEspecial($numero, $tipo, $limite);
                break;

            default:
                $tipo = 'CONTA_POUPANCA';
        }
    }
}