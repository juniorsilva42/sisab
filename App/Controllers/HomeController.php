<?php

namespace App\Controllers;

use Core\View;

class HomeController extends \Core\Controller {

    public function indexAction () {
        View::renderTemplate('Home/index', ['useCompressor' => true]);
    }
}