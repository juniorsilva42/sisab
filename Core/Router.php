<?php

namespace Core;

class Router {

    protected $routes = [];
    protected $params = [];

    public function add ($route, $params = []) {

        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    public function getRoutes () {
        return $this->routes;
    }

    public function getParams () {
        return $this->params;
    }
}