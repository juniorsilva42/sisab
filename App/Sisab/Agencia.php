<?php

namespace App\Sisab;

class Agencia {

    private $nome;
    private $numero;
    private $endereco;
    private $capacidade;

    public function __construct ($numero, $nome, $endereco, $capacidade) {
        $this->nome = $nome;
        $this->numero = $numero;
        $this->endereco = $endereco;
        $this->capacidade = $capacidade;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function getCapacidade() {
        return $this->capacidade;
    }
}