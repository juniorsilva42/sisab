<?php

namespace App\Controllers;

use Core\View;
use Core\Util\HttpHelpers;

class ClientesController extends \Core\Controller {

    public function indexAction () {
        View::renderTemplate('Clientes/index');
    }

    public function getById () {

        $id = HttpHelpers::getRestrictionId($_SERVER['QUERY_STRING']);

        View::renderTemplate('Clientes/getById', [
            'id' => $id
        ]);
    }
}