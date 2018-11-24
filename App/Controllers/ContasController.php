<?php

namespace App\Controllers;

use App\Models\ContasModel;
use Core\View;

class ContasController extends \Core\Controller {

    public function indexAction () {

        $contas = ContasModel::getAll();

        foreach ($contas as $conta) {
            $params = [
                'id' => $conta->id,
                'nome' => $conta->nome
            ];

            View::renderTemplate('Contas/index', $params);
        }
    }
}