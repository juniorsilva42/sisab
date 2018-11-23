<?php

namespace Core;

class View {

    public static function render ($view, $args = []) {
        extract($args, EXTR_SKIP);
        $file = dirname(__DIR__) . DIRECTORY_SEPARATOR . "App/Views/{$view}";

        if (is_readable($file)):
            require $file;
        else:
            throw new \Exception("A view {$file} não foi encontrada!");
        endif;
    }

    public static function renderTemplate () {

    }
}