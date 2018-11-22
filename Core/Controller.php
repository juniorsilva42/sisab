<?php

namespace App\Core;

abstract class Controller {

    protected $route_params = [];

    public function __construct ($route_params) {
        $this->route_params = $route_params;
    }
}