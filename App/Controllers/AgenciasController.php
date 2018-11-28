<?php

namespace App\Controllers;

use App\Sisab\Agencia;
use App\Sisab\Exception\ModelException;
use Core\Util\HttpHelpers;
use Core\View;

use App\Models\AgenciasModel;
use DateTime;

class AgenciasController extends \Core\Controller {

    public function indexAction () {
        View::renderTemplate('Agencias/index', [
            'signature' => hash("sha256", "902ef2c77423503981468993d8aec16f.id")
        ]);
    }
    
    public function listarAction () {

        $agenciasList = AgenciasModel::getAll();

        View::renderTemplate('Agencias/listar', [
            'agencias' => $agenciasList,
            'quantidade_agencias' => count($agenciasList)
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

        // Seta o estado pro model, onde vai utilizar esses dados para inserir no banco de dados
        $state = AgenciasModel::create($agencia);

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

    public function deletarAction () {

        $agencia_id = HttpHelpers::getId($_SERVER['QUERY_STRING']);

        try {
            $state = AgenciasModel::delete($agencia_id);

            // Controle as flash messages baseado no retorno do Model
            if ($state):
                $flashMessage = 'A agência foi deletada com sucesso!';
                $alert = 'success';
            else:
                $flashMessage = 'Erro ao deletar a agência!';
                $alert = 'danger';
            endif;

            header('location: http://localhost/sisab/agencias/listar');
        } catch (ModelException $e) {
            $flashMessage = "Erro ao deletar a agência!";
            $alert = 'danger';
        }

        // Renderiza o template implantando as variáveis de controle
        View::renderTemplate('Agencias/listar', [
            'flashMessage' => $flashMessage,
            'flashAlert' => isset($alert),
            'newMessage' => true
        ]);
    }

    public function editar () {

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

                $state = AgenciasModel::editar($agencia);

                // Controle as flash messages baseado no retorno do Model
                if ($state):
                    $flashMessage = 'A agência foi editada com sucesso!';
                    $alert = 'success';
                else:
                    $flashMessage = 'Erro ao editar a agência!';
                    $alert = 'danger';
                endif;

                View::renderTemplate("Agencias/editar", [
                    'flashMessage' => $flashMessage,
                    'flashAlert' => isset($alert),
                    'newMessage' => true
                ]);
            } catch (ModelException $e) {}

        }
    }
}