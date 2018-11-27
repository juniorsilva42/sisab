<?php

namespace App\Controllers;

use App\Models\ContasModel;
use Core\View;

class AgenciasController extends \Core\Controller {

    public function indexAction () {
        View::renderTemplate('Agencias/index');
    }
}