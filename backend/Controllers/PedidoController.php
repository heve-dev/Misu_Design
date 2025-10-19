<?php
namespace App\Misu\Controllers;

use App\Misu\Model\Pedido;
use App\Misu\Database\Database;
use App\Misu\Core\View;
use App\Misu\Core\Redirect;
use App\Misu\Validadores\PedidoValidador;

class PedidoController {
    public $pedido;
    public $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->pedido = new Pedido($this->db);
    }

    public function salvarPedidos() {
        $erros = PedidoValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("pedido/criar","error", implode("<br>", $erros));
        }

        if($this->pedido->registrarPedidos(
            $_POST["id_cliente"],
            $_POST["id_pagamento"] ?? null,
            $_POST["descricao_pedido"],
            $_POST["status_pedido"],
            $_POST["data_pedido"]
        )){
            Redirect::redirecionarComMensagem("pedido/listar","success","Orçamento cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("pedido/criar","error","Erro ao cadastrar orçamento!");
        }
    }

    public function index() {
        $resultado = $this->pedido->buscarPedidos();
        var_dump($resultado);
    }

    public function viewListarPedidos($pagina) {
        $dados = $this->pedido->paginacao($pagina);
        $total = $this->pedido->totalDePedidos();
        View::render("pedido/index", [
            "pedidos"=> $dados,
            "total_pedidos"=> $total[0],
            "total_inativos" => 22,
            "total_ativos" => 12
        ]);
    }

    public function viewCriarPedidos() {
        View::render("pedido/create");
    }

    public function viewEditarPedido($id) {
        $dados = $this->pedido->buscarPedidosPorId($id);
        foreach($dados as $pedido){
            $dados = $pedido;
        }
        View::render("pedido/edit", ["pedido"=> $dados]);
    }

    public function viewExcluirPedidos($id){
        View::render("pedido/delete", ["id_pedido"=> $id]);
    }

    public function atualizarPedidos() {
        echo "Atualizar Pedido";
    }

    public function deletarPedidos() {
        echo "Deletar Pedido";  
    }
}
?>
