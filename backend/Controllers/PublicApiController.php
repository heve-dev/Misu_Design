<?php
namespace App\Misu\Controllers;

use App\Misu\Model\Servico;
use App\Misu\Database\Database;
use App\Misu\Model\Produto;
use App\Misu\Model\Pedido;

class PublicApiController {
    private $servicoModel;
    private $produtoModel;
    private $pedidoModel;
    public function __construct() {
        $db = Database::getInstance();
        $this->servicoModel = new Servico($db);
        $this->produtoModel = new Produto($db);
        $this->pedidoModel = new Pedido($db);
    }

    public function getServicos() {
        $dados = $this->servicoModel->buscarServicosAtivos();
        //  & no foreach anexa a mudança nos dados reais do array
        foreach ($dados as &$servico) {
            $servico['caminho_imagem'] = '/backend/upload/' . $servico['foto_servico'];
        }
        unset($servico); // Quebra a referência do último elemento
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'data' => $dados
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public function getProdutos() {
        header('Content-Type: application/json');
        $dados = $this->produtoModel->buscarProdutosAtivos();
        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'data' => $dados
        ], JSON_UNESCAPED_SLASHES);
        exit;
    }
public function salvarPedidos() {
        header('Content-Type: application/json');
        $carrinho = json_decode(file_get_contents('php://input'), true);
        if (empty($carrinho) || !is_array($carrinho)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Nenhum item no carrinho.'
            ]);
            exit;
        }
        $novoPedidoId = $this->pedidoModel->criarPedidos($carrinho);
        if ($novoPedidoId) {
            http_response_code(201);
            echo json_encode([
                'status' => 'success',
                'message' => 'Pedido criado com sucesso.',
                'pedido_id' => $novoPedidoId
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Erro ao criar o pedido. Tente novamente.'
            ]);
        }
       exit;
    }
}