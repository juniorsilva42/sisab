<?php

namespace App\Controllers;

use Core\View;

use App\Models\AgenciasModel;

class AgenciasController extends \Core\Controller {

    public function indexAction () {
        View::renderTemplate('Agencias/index');
    }

    public function listarAction () {

        $agenciasList = AgenciasModel::getAll();

        View::renderTemplate('Agencias/listar', [
            'agencias' => $agenciasList
        ]);
    }
}