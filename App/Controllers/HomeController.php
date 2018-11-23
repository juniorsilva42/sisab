<?php

namespace App\Controllers;

use Core\View;

class HomeController extends \Core\Controller {

    public function indexAction () {
        // View::renderTemplate('Home/index.html');

        View::renderTemplate('Home/index.html', [
            'name' => 'Junior Silva',
            'message' => 'i\'d\' like a coffee glass'
        ]);
    }
}