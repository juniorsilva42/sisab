<?php

namespace App\Sisab\Exception;

use Exception;

final class FormatoNumeroException extends Exception {

    public function __construct(string $message = "") {
        parent::__construct($message);
    }
}