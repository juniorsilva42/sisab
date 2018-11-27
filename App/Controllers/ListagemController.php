<?php

namespace App\Controllers;

use Core\View;

class ListagemController extends \Core\Controller {

    public function indexAction () {
        View::renderTemplate('Listagem/index');
    }
}