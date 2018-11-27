<?php

namespace App\Controllers;

use App\Models\ContasModel;
use Core\View;

class ContasController extends \Core\Controller {

    public function indexAction () {

        View::renderTemplate('Contas/index');
    }

    public function listar () {

        $contas = ContasModel::getAll();

        View::renderTemplate('Contas/listar', [
            'contas' => $contas
        ]);
    }
}