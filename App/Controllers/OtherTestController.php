<?php

namespace App\Controllers;

use Util\HttpHelpers;

class OtherTestController extends \Core\Controller {

    public function indexAction () {
        // echo ucwords(hash("sha256", "902ef2c77423503981468993d8aec16f.id"));

        echo HttpHelpers::getRestrictionId($_SERVER['QUERY_STRING']);
    }

}