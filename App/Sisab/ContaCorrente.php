<?php

namespace App\Sisab;

use App\Sisab\Exception\EstouroSaldoException;

final class ContaCorrente extends Conta {

    /* *
     *
     * Anotação:
     *
     * PHP é uma linguagem dinâmica, portanto isto não faz sentido.

Até existe um conceito chamado overloading mas que é um pouco diferente do que você está pensando mas consegue resultado semelhante.

Em linguagens dinâmicas os parâmetros podem receber qualquer tipo então a resolução do que fazer com eles deve ser dado em tempo de execução através de seleção (if, switch, elemento de array ou outra forma).

Se realmente quer ter métodos que fazem quase a mesma coisa com parâmetros diferentes tem que trocar o nome. Mas o mais comum é que um método faça mais de uma coisa baseado no parâmetro. É, eu sei, para quem está acostumado com tudo organizado em funções únicas parece estranho mas muitas vezes fica até interessante e poupa código.

Normalmente costuma-se dizer que um parâmetro é do tipo mixed. Este tipo não existe de fato, é apenas um indicativo que pode-se usar mais de um tipo de dado ali. Exemplo:
     *
     * */

    public function __construct($numConta = null, $tipo) {
        parent::__construct($numConta, $tipo);
    }

    public function saque($valor) {
        if ($valor <= $this->saldo) {
            $this->saldo -= $valor;
        } else {
            throw new EstouroSaldoException("Saldo insuficiente");
        }
    }

    public function extrato() {
        return "Conta Corrente: <br> Numero da Conta: {$this->numero} <br> Saldo: {$this->saldo}";
    }
}