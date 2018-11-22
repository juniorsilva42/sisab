<?php

namespace App\Sisab;

class Agencia {

    private $nome;
    private $numero;
    private $endereco;

    public function __construct ($numero, $nome, $endereco) {
        $this->nome = $nome;
        $this->numero = $numero;
        $this->endereco = $endereco;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }
}