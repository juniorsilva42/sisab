<?php

namespace App\Controllers;

use App\Models\AgenciasModel;
use App\Models\ContasModel;
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
}