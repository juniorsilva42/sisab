<?php

namespace Core;

class View {

    private static $defaultViewExtension = '.html';

    public static function render ($view, $args = []) {
        extract($args, EXTR_SKIP);
        $file = dirname(__DIR__)
            . DIRECTORY_SEPARATOR . 'App'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR . $view . '.html';

        if (is_readable($file)):
            require $file;
        else:
            throw new \Exception("A view {$file} não foi encontrada!");
        endif;
    }

    public static function renderTemplate ($template, $args = []) {

        static $twig = null;
        $template .= self::$defaultViewExtension;

        if ($twig == null) {
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__)
                .DIRECTORY_SEPARATOR.'App'.DIRECTORY_SEPARATOR . 'Views');
            $twig = new \Twig_Environment($loader);
        }

        echo $twig->render($template, $args);
    }
}