<?php

namespace App\Controllers;

use Core\View;

use App\Models\ContasModel;
use App\Models\AgenciasModel;

class ListagemController extends \Core\Controller {

    public function indexAction () {
        $agencias = AgenciasModel::getAll();
        $contas = ContasModel::getAll();

        View::renderTemplate('Listagem/index', [
            'agencias' => $agencias,
            'contas' => $contas,
            'qtd_contas' => count($contas),
            'qtd_agencias' => count($agencias)
        ]);
    }
}