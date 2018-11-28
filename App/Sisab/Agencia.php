<?php

namespace App\Sisab;

class Agencia {

    private $id;
    private $nome;
    private $numero;
    private $endereco;
    private $capacidade;

    public function __construct ($numero, $nome, $endereco, $capacidade, $id = null) {
        $this->nome = $nome;
        $this->numero = $numero;
        $this->endereco = $endereco;
        $this->capacidade = $capacidade;
        $this->id = $id;
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

    public function getId() {
        return $this->id;
    }
}