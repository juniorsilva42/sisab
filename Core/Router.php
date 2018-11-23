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

    public function match ($url) {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key))
                        $params[$key] = $match;
                }
                $this->params = $params;
                return true;
            }
        }

        return false;
    }

    protected function removeQueryStringVariables($url) {

        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return $url;
    }

    public function dispatch ($url) {

    }

    protected function getNamespace () {

        $namespace = 'App\Controllers\\';

        if (array_key_exists('namespace', $this->params))
            $namespace .= $this->params['namespace'].'\\';

        return $namespace;
    }

    protected function convertToStudlyCaps($string) {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    protected function convertToCamelCase($string) {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    public function getRoutes () {
        return $this->routes;
    }

    public function getParams () {
        return $this->params;
    }
}