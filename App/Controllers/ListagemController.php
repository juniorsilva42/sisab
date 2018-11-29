<?php

namespace App\Controllers;

use Core\View;

use App\Models\ContasModel;
use App\Models\AgenciasModel;

use DateTime;

class ListagemController extends \Core\Controller {

    public function indexAction () {

        /* *
         *
         * TO-DO: adicionar exceção
         *
         * */
        $agencias = AgenciasModel::getAll();
        $contas = ContasModel::getAll();

        View::renderTemplate('Listagem/index', [
            'agencias' => $agencias,
            'contas' => $contas,
            'quantidade' => count($contas),
            'quantidade_agencias' => count($agencias)
        ]);
    }
}