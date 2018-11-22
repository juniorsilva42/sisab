<?php

error_reporting(E_ALL);

// Composer autoload
require dirname(__DIR__) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

use Core\Router;

$route = new Router();

echo $route->add('/signup');
