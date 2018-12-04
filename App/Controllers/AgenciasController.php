<?php

namespace App\Controllers;

use App\Sisab\Agencia;
use App\Sisab\Exception\ModelException;
use Core\Util\HttpHelpers;
use Core\View;

use App\Models\AgenciasModel;

class AgenciasController extends \Core\Controller {

    public function indexAction () {
        View::renderTemplate('Agencias/index');
    }
    
    public function listarAction () {

        try {
            $agenciasList = AgenciasModel::getAll();
        } catch (\PDOException $e) {
            $contas = null;
            $flashMessage = $e->getMessage();
            $alert = 'danger';
        }

        View::renderTemplate('Agencias/listar', [
            'agencias' => (isset($agenciasList)) ? $agenciasList : null,
            'quantidade_agencias' => isset($agenciasList) ? count($agenciasList) : null,
            'notification' => [
                'newMessage' => true,
                'state' => true,
                'flashMessage' => isset($flashMessage) ? $flashMessage : false,
                'flashAlert' => isset($alert) ? $alert : false,
                'redirect' => false
            ]
        ]);
    }

    public function criarAction () {

        // Obtem os dados do formulário pela Query String do Request
        $nome = (isset($_REQUEST['nome'])) ? $_REQUEST['nome'] : 'Agência Bradesco Sem nome';
        $numero = (isset($_REQUEST['numero'])) ? $_REQUEST['numero'] : 'Agência Bradesco Sem nome';
        $endereco = (isset($_REQUEST['endereco'])) ? $_REQUEST['endereco'] : 'Endereço Padrão';
        $capacidade = (isset($_REQUEST['capacidade'])) ? $_REQUEST['capacidade'] : 500;

        // Povoa o objeto pelos dados obtidos
        $agencia = new Agencia($numero, $nome, $endereco, $capacidade);

        try {
            $state = AgenciasModel::create($agencia);

            $notification = [
                'newMessage' => true,
                'state' => true,
                'flashMessage' => 'Agência adicionada com sucesso!',
                'flashAlert' => 'success'
            ];
        } catch (\PDOException $e) {
            $notification = [
                'newMessage' => true,
                'state' => false,
                'flashMessage' => $e->getMessage(),
                'flashAlert' => 'danger',
                'redirect' => true
            ];
        }

        // Renderiza o template implantando as variáveis de controle
        View::renderTemplate('Agencias/index', [
            'notification' => $notification
        ]);
    }

    public function deletarAction () {

        $agencia_id = HttpHelpers::getId($_SERVER['QUERY_STRING']);

        try {
            $state = AgenciasModel::delete($agencia_id);

            $notification = [
                'newMessage' => true,
                'state' => true,
                'redirect' => true,
                'flashMessage' => 'Agência deletada com sucesso!',
                'flashAlert' => 'success'
            ];
        } catch (\PDOException $e) {
            $notification = [
                'newMessage' => true,
                'state' => false,
                'quantidade' => 'undefined',
                'redirect' => true,
                'flashMessage' => $e->getMessage(),
                'flashAlert' => 'danger'
            ];
        }

        // Renderiza o template implantando as variáveis de controle
        View::renderTemplate('Agencias/listar', [
            'notification' => $notification,
            'quantidade' => 'undefined'
        ]);
    }

    public function editarAction () {

        // Obtem os dados do formulário pela Query String do Request
        $id_agencia = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : null;
        $nome_agencia = (isset($_REQUEST['nome'])) ? $_REQUEST['nome'] : null;
        $numero = (isset($_REQUEST['numero'])) ? $_REQUEST['numero'] : null;
        $endereco = (isset($_REQUEST['endereco'])) ? $_REQUEST['endereco'] : null;
        $capacidade = (isset($_REQUEST['capacidade'])) ? $_REQUEST['capacidade'] : null;

        $sign = (isset($_REQUEST['sign'])) ? $_REQUEST['sign'] : null;

        if (!isset($sign) || $sign != 'do') {
            View::renderTemplate("Agencias/editar", [
                'id_agencia' => $id_agencia,
                'nome_agencia' => $nome_agencia,
                'numero_agencia' => $numero,
                'endereco' => $endereco,
                'capacidade' => $capacidade
            ]);
        } else {

            try {
                // Atualiza o objeto com os novos dados atualizados (ou não)
                $agencia = new Agencia($numero, $nome_agencia, $endereco, $capacidade, $id_agencia);

                $state = AgenciasModel::update($agencia);

                // Controle as flash messages baseado no retorno do Model
                if ($state):
                    $flashMessage = 'A agência foi atualizada com sucesso!';
                    $alert = 'success';
                else:
                    $flashMessage = 'OPA! Houve algum erro ao atualizar à agência!';
                    $alert = 'danger';
                endif;

                View::renderTemplate("Agencias/editar", [
                    'flashMessage' => $flashMessage,
                    'flashAlert' => $alert,
                    'newMessage' => true
                ]);

            } catch (ModelException $e) {}

        }
    }
}