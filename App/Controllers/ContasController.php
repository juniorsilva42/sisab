<?php

namespace App\Controllers;

use App\Models\ContasModel;
use Core\View;

class ContasController extends \Core\Controller {

    public function indexAction () {

        $contas = ContasModel::getAll();

        echo '<pre>';
        print_r($contas);
        echo '</pre>';

        View::renderTemplate('Contas/index', [
            'contas' => $contas
        ]);
        /*
        foreach ($contas as $conta) {
            $params = [
                'id' => $conta->id,
                'nome' => $conta->nome
            ];

            View::renderTemplate('Contas/index');
        }*/
    }
}