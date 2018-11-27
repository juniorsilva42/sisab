<?php

namespace App\Sisab\Exception;

use Exception;

final class ModelException extends Exception {

    public function __construct(string $message = "") {
        parent::__construct($message);
    }
}