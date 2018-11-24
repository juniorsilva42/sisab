<?php

namespace App\Controllers;

use App\Models\ContasModel;
use Core\View;

class ContasController extends \Core\Controller {

    public function indexAction () {
        // var_dump(ContasModel::getAll()->nome);

        $contas = ContasModel::getAll();

        View::renderTemplate('Contas/index', [
            'id' => $contas->id,
            'nome' => $contas->nome
        ]);
    }
}