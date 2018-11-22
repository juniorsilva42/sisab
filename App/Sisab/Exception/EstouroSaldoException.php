<?php

namespace App\Sisab\Exception;

class EstouroSaldoException extends \Exception {

    public function __construct(string $message = "", int $code = 0) {
        parent::__construct($message, $code);
    }
}