<?php

namespace App\Controllers;

use App\Models\AgenciasModel;
use App\Models\ContasModel;
use App\Sisab\ContaCorrente;
use App\Sisab\ContaEspecial;
use App\Sisab\ContaPoupanca;
use App\Sisab\Exception\EstouroSaldoException;
use App\Sisab\Exception\FormatoNumeroException;
use App\Sisab\Exception\ModelException;
use Core\Util\HttpHelpers;
use Core\View;

class ContasController extends \Core\Controller {

    public function indexAction () {
        $agencias = AgenciasModel::getAll();

        View::renderTemplate('Contas/index', [
            'agencias' => $agencias
        ]);
    }

    public function listar () {

        try {
            $contas = ContasModel::getAll();
        } catch (\PDOException $e) {
            $contas = null;
            $flashMessage = $e->getMessage();
            $alert = 'danger';
        }

        View::renderTemplate('Contas/listar', [
            'contas' => $contas,
            'quantidade' => (isset($contas)) ? count($contas) : 0,
            'notification' => [
                'newMessage' => true,
                'state' => true,
                'flashMessage' => isset($flashMessage) ? $flashMessage : false,
                'flashAlert' => isset($alert) ? $alert : false
            ]
        ]);
    }

    public function criarAction () {

        // Obtem os dados do formulário pela Query String do Request
        // (isset($_REQUEST['numero'])) ? $_REQUEST['numero'] : null

        $numero = $_REQUEST['numero'] ?? 'null';
        $limite = $_REQUEST['limite'] ?? null;
        $rendimento = $_REQUEST['rendimento'] ?? null;
        $tipo = $_REQUEST['tipo'] ?? 'CONTA_POUPANCA';
        $id_agencia = $_REQUEST['agencia'] ?? 0;

        switch ($tipo) {
            case 'CONTA_POUPANCA':
                $conta = new ContaPoupanca($numero, $tipo, $rendimento);
                $conta->setIdAgencia($id_agencia);
                break;

            case 'CONTA_CORRENTE':
                $conta = new ContaCorrente($numero, $tipo);
                $conta->setIdAgencia($id_agencia);
                break;

            case 'CONTA_ESPECIAL':
                $conta = new ContaEspecial($numero, $tipo, $limite);
                $conta->setIdAgencia($id_agencia);
                break;

            default:
                $conta = new ContaPoupanca($numero, $tipo, $rendimento);
                $conta->setIdAgencia($id_agencia);
        }

        try {
            $state = ContasModel::create($conta);

            $notification = [
                'newMessage' => true,
                'state' => true,
                'flashMessage' => 'Conta adicionada com sucesso!',
                'flashAlert' => 'success'
            ];
        } catch (\PDOException $e) {
            $notification = [
                'newMessage' => true,
                'state' => false,
                'flashMessage' => $e->getMessage(),
                'flashAlert' => 'danger'
            ];
        } catch (FormatoNumeroException $e) {
            $notification = [
                'newMessage' => true,
                'state' => false,
                'flashMessage' => $e->getMessage(),
                'flashAlert' => 'danger'
            ];
        }

        // Renderiza o template implantando as variáveis de controle
        View::renderTemplate('Contas/index', [
            'notification' => $notification,
            'quantidade_agencias' => 'undefined'
        ]);
    }

    public function deletarAction () {

        $id_conta = HttpHelpers::getId($_SERVER['QUERY_STRING']);

        try {
            $state = ContasModel::delete($id_conta);

            $notification = [
                'newMessage' => true,
                'state' => true,
                'redirect' => true,
                'flashMessage' => 'Conta deletada com sucesso!',
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
        View::renderTemplate('Contas/listar', [
            'notification' => $notification,
            'quantidade' => 'undefined'
        ]);
    }

    public function editarAction () {

        // Obtem os dados do formulário pela Query String do Request
        $id_conta = $_REQUEST['cid'] ?? null;
        $numero = $_REQUEST['numero'] ?? null;
        $saldo = $_REQUEST['saldo'] ?? null;
        $limite = $_REQUEST['limite'] ?? null;
        $rendimento = $_REQUEST['rendimento'] ?? null;
        $tipo = $_REQUEST['tipo'] ?? null;

        $sign = $_REQUEST['sign'] ?? null;

        if (!isset($sign) || $sign != 'do') {
            View::renderTemplate("Contas/editar", [
                'id_conta' => $id_conta,
                'numero' => $numero,
                'saldo' => $saldo,
                'limite' => $limite,
                'rendimento' => $rendimento,
                'tipo' => $tipo
            ]);
        } else {

            switch ($tipo) {
                case 'CONTA_POUPANCA':
                    $conta = new ContaPoupanca($numero, $tipo, $rendimento);
                    $conta->setId($id_conta);
                    break;

                case 'CONTA_CORRENTE':
                    $conta = new ContaCorrente($numero, $tipo);
                    $conta->setId($id_conta);
                    break;

                case 'CONTA_ESPECIAL':
                    $conta = new ContaEspecial($numero, $tipo, $limite);
                    $conta->setId($id_conta);
                    break;

                default:
                    $conta = new ContaPoupanca($numero, $tipo, $rendimento);
                    $conta->setId($id_conta);
            }

            try {
                $state = ContasModel::update($conta);

                $notification = [
                    'flashMessage' => 'Conta atualizada com sucesso!',
                    'alert' => 'success',
                    'newMessage' => true,
                    'state' => true
                ];

            } catch (\PDOException $e) {
                $notification = [
                  'flashMessage' => $e->getMessage(),
                  'alert' => 'danger',
                  'newMessage' => true,
                  'state' => false
                ];
            }

            View::renderTemplate("Contas/listar", [
                'notification' => $notification,
                'quantidade' => 'undefined'
            ]);
        }
    }

    public function depositoAction () {
        $contas = ContasModel::getAll();

        View::renderTemplate('Contas/deposito/index', [
            'contas' => $contas
        ]);
    }

    public function transferenciaAction () {
        $contas = ContasModel::getAll();

        View::renderTemplate('Contas/transferencia/index', [
            'contas' => $contas
        ]);
    }

    public function saqueAction () {
        $contas = ContasModel::getAll();

        View::renderTemplate('Contas/saque/index', [
            'contas' => $contas
        ]);
    }

    public function extratoAction () {

        $id = HttpHelpers::getId($_SERVER['QUERY_STRING']);

        try {
            $conta = ContasModel::getById($id);
        } catch (\PDOException $e) {
            $conta = null;
            $flashMessage = $e->getMessage();
            $alert = 'danger';
        }

        View::renderTemplate('Extrato/index', [
            'conta' => $conta,
            'notification' => [
                'newMessage' => true,
                'error' => ($conta == null) ? true : false,
                'flashMessage' => $flashMessage ?? false,
                'flashAlert' => $alert ?? false
            ]
        ]);
    }

    public function operacaoAction () {

        // Obtem os dados do formulário pela Query String do Request
        $agencia = (isset($_REQUEST['agencia'])) ? $_REQUEST['agencia'] : false;
        $id_conta = (isset($_REQUEST['conta'])) ? $_REQUEST['conta'] : null;
        $valor = (isset($_REQUEST['valor'])) ? $_REQUEST['valor'] : 0;
        $operacao = (isset($_REQUEST['operacao'])) ? $_REQUEST['operacao'] : 0;
        $id_conta_origem = (isset($_REQUEST['conta_origem'])) ? $_REQUEST['conta_origem'] : 0;
        $id_conta_destino = (isset($_REQUEST['conta_destino'])) ? $_REQUEST['conta_destino'] : 0;

        switch ($operacao) {

            case 'deposito':

                try {
                    $state = ContasModel::deposito($id_conta, $valor);

                    $notification = [
                        'newMessage' => true,
                        'flashMessage' => "O depósito de R$ ${valor} foi transacionado com sucesso!",
                        'flashAlert' => 'success',
                        'state' => true
                    ];

                } catch (\PDOException $e) {
                    $notification = [
                        'newMessage' => true,
                        'flashMessage' => $e->getMessage(),
                        'flashAlert' => 'danger',
                        'state' => false
                    ];
                }
                break;

            case 'saque':

                try {
                    $state = ContasModel::saque($id_conta, $valor);

                    $notification = [
                        'newMessage' => true,
                        'flashMessage' => "O saque de R$ {$valor} foi transacionado com sucesso!",
                        'flashAlert' => 'success',
                        'state' => true
                    ];
                } catch (\PDOException $e) {
                    $notification = [
                        'newMessage' => true,
                        'flashMessage' => $e->getMessage(),
                        'flashAlert' => 'danger',
                        'state' => false
                    ];
                } catch (EstouroSaldoException $e) {
                    $notification = [
                        'newMessage' => true,
                        'flashMessage' => $e->getMessage(),
                        'flashAlert' => 'danger',
                        'state' => false
                    ];
                }

                break;

            case 'transferencia':

                if ($id_conta_origem == $id_conta_destino) {
                    $notification = [
                        'newMessage' => true,
                        'flashMessage' => "Erro ao transacionar esta transferência. A conta de origem não pode ser igual a conta de destino.",
                        'flashAlert' => 'danger',
                        'state' => false
                    ];
                } else {
                    try {
                        $state = ContasModel::transferencia($id_conta_origem, $id_conta_destino, $valor);

                        $notification = [
                            'newMessage' => true,
                            'flashMessage' => "A transferência de R$ ${valor} foi transacionada entre as contas com sucesso!",
                            'flashAlert' => 'success',
                            'state' => true
                        ];
                    } catch (\PDOException $e) {
                        $notification = [
                            'newMessage' => true,
                            'flashMessage' => $e->getMessage(),
                            'flashAlert' => 'danger',
                            'state' => false
                        ];
                    } catch (EstouroSaldoException $e) {
                        $notification = [
                            'newMessage' => true,
                            'flashMessage' => $e->getMessage(),
                            'flashAlert' => 'danger',
                            'state' => false
                        ];
                    }
                }

                break;

            default:
                echo 'Operação inválida!';
        }

        if ($operacao == 'deposito') {
            $view = 'Contas/deposito/index';
        } else if ($operacao == 'saque') {
            $view = 'Contas/saque/index';
        } else if ($operacao == 'transferencia') {
            $view = 'Contas/transferencia/index';
        }

        View::renderTemplate($view, [
            'notification' => $notification,
            'tipo' => 'operacao',
            'operacao' => $operacao,
            'id_conta' => $id_conta,
            'quantidade_agencias' => 'undefined'
        ]);
    }
}