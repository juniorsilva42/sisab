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

        // Obtem os dados do formulário pela Query String do Request
        $nome = ($_REQUEST['nome']) ? $_REQUEST['nome'] : 'Agência Bradesco Sem nome';
        $numero = ($_REQUEST['numero']) ? $_REQUEST['numero'] : 'Agência Bradesco Sem nome';
        $endereco = ($_REQUEST['endereco']) ? $_REQUEST['endereco'] : 'Endereço Padrão';
        $capacidade = ($_REQUEST['capacidade']) ? $_REQUEST['capacidade'] : 500;

        // Povoa o objeto pelos dados obtidos
        $agencia = new Agencia($numero, $nome, $endereco, $capacidade);

        // Seta o estado pro model, onde vai utilizar esses dados para inserir no banco de dados
        $state = AgenciasModel::createNewAgency($agencia);

        // Controle as flash messages baseado no retorno do Model
        if ($state):
            $flashMessage = 'A agência foi cadastrada com sucesso!';
            $alert = 'success';
        else:
            $flashMessage = 'Erro ao inserir a agência!';
            $alert = 'danger';
        endif;

        // Renderiza o template implantando as variáveis de controle
        View::renderTemplate('Agencias/index', [
            'flashMessage' => $flashMessage,
            'flashAlert' => $alert,
            'newMessage' => true
        ]);
    }
}