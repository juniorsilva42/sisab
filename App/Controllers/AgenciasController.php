<?php

namespace App\Controllers;

use App\Sisab\Agencia;
use Core\View;

use App\Models\AgenciasModel;

class AgenciasController extends \Core\Controller {

    public function indexAction () {
        View::renderTemplate('Agencias/index', [
            'signature' => hash("sha256", "902ef2c77423503981468993d8aec16f.id")
        ]);
    }

    public function listarAction () {

        $agenciasList = AgenciasModel::getAll();

        View::renderTemplate('Agencias/listar', [
            'agencias' => $agenciasList
        ]);
    }

    public function criarAction () {

        $nome = ($_REQUEST['nome']) ? $_REQUEST['nome'] : 'Agência Bradesco Sem nome';
        $numero = ($_REQUEST['numero']) ? $_REQUEST['numero'] : 'Agência Bradesco Sem nome';
        $endereco = ($_REQUEST['endereco']) ? $_REQUEST['endereco'] : 'Endereço Padrão';
        $capacidade = ($_REQUEST['capacidade']) ? $_REQUEST['capacidade'] : 500;

        $agencia = new Agencia($numero, $nome, $endereco, $capacidade);
        $state = AgenciasModel::createNewAgency($agencia);

        if ($state) {
            $flashMessage = 'A agência foi cadastrada com sucesso!';
            $alert = 'success';
        } else {
            $flashMessage = 'Erro ao inserir a agência!';
            $alert = 'danger';
        }

        View::renderTemplate('Agencias/index', [
            'flashMessage' => $flashMessage,
            'flashAlert' => $alert,
            'newMessage' => true
        ]);
    }
}