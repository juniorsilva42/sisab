<?php

namespace App\Controllers;

use Core\View;

class ClientesController extends \Core\Controller {

    public function indexAction () {
        View::renderTemplate('Clientes/index.html');
    }
}