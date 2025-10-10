<?php
namespace App\Misu\Controllers;

use App\Misu\Model\Pagamento;
use App\Misu\Database\Database;
use App\Misu\Core\View;
use App\Misu\Core\Redirect;
use App\Misu\Validadores\PagamentoValidador;

class PagamentoController {
    public $pagamento;
    public $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->pagamento = new Pagamento($this->db);
    }

    public function salvarPagamento() {
        $erros = PagamentoValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("pagamento/criar","error", implode("<br>", $erros));
        }

        if($this->pagamento->registrarPagamento(
            $_POST["id_cliente"],
            $_POST["total_devedor"],
            $_POST["status_pagamento"],
            $_POST["data_pagamento"]
        )){
            Redirect::redirecionarComMensagem("pagamento/listar","success","Pagamento cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("pagamento/criar","error","Erro ao cadastrar pagamento!");
        }
    }

    public function index() {
        $resultado = $this->pagamento->buscarPagamentos();
        var_dump($resultado);
    }

    public function viewListarPagamentos($pagina) {
        $dados = $this->pagamento->paginacao($pagina);
        $total = $this->pagamento->totalDePagamentos();
        View::render("pagamento/index", [
            "pagamentos"=> $dados,
            "total_pagamentos"=> $total[0],
            "total_inativos" => 22,
            "total_ativos" => 12
        ]);
    }

    public function viewCriarPagamento() {
        View::render("pagamento/create");
    }

    public function viewEditarPagamento($id) {
        $dados = $this->pagamento->buscarPagamentoPorId($id);
        foreach($dados as $pagamento){
            $dados = $pagamento;
        }
        View::render("pagamento/edit", ["pagamento"=> $dados]);
    }

    public function viewExcluirPagamento($id){
        View::render("pagamento/delete", ["id_pagamento"=> $id]);
    }

    public function atualizarPagamento() {
        echo "Atualizar Pagamento";
    }

    public function deletarPagamento() {
        echo "Deletar Pagamento";  
    }
}
?>
