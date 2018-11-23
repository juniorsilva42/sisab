<?php

namespace App\Controllers;

use Core\View;

class HomeController extends \Core\Controller {

    public function indexAction () {
        View::renderTemplate('Home/index.html', [
            'name' => 'Junior Silva',
            'message' => 'i\'d\' like a coffee glass',
            'signature' => hash("sha256", "902ef2c77423503981468993d8aec16f.id")
        ]);
    }
}