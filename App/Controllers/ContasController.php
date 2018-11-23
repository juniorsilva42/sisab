<?php

namespace App\Controllers;

use Core\View;

class ContasController extends \Core\Controller {

    public function indexAction () {
        View::renderTemplate('Contas/index.html');
    }
}