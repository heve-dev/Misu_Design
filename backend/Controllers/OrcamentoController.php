<?php
namespace App\Misu\Controllers;

use App\Misu\Model\Orcamento;
use App\Misu\Database\Database;
use App\Misu\Core\View;
use App\Misu\Core\Redirect;
use App\Misu\Validadores\OrcamentoValidador;

class OrcamentoController {
    public $orcamento;
    public $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->orcamento = new Orcamento($this->db);
    }

    public function salvarOrcamento() {
        $erros = OrcamentoValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("orcamento/criar","error", implode("<br>", $erros));
        }

        if($this->orcamento->registrarOrcamento(
            $_POST["id_cliente"],
            $_POST["id_categoria"],
            $_POST["id_pagamento"] ?? null,
            $_POST["descricao_orcamento"],
            $_POST["status_orcamento"],
            $_POST["data_orcamento"]
        )){
            Redirect::redirecionarComMensagem("orcamento/listar","success","Orçamento cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("orcamento/criar","error","Erro ao cadastrar orçamento!");
        }
    }

    public function index() {
        $resultado = $this->orcamento->buscarOrcamentos();
        var_dump($resultado);
    }

    public function viewListarOrcamentos($pagina) {
        $dados = $this->orcamento->paginacao($pagina);
        $total = $this->orcamento->totalDeOrcamentos();
        View::render("orcamento/index", [
            "orcamentos"=> $dados,
            "total_orcamentos"=> $total[0],
            "total_inativos" => 22,
            "total_ativos" => 12
        ]);
    }

    public function viewCriarOrcamento() {
        View::render("orcamento/create");
    }

    public function viewEditarOrcamento($id) {
        $dados = $this->orcamento->buscarOrcamentoPorId($id);
        foreach($dados as $orcamento){
            $dados = $orcamento;
        }
        View::render("orcamento/edit", ["orcamento"=> $dados]);
    }

    public function viewExcluirOrcamento($id){
        View::render("orcamento/delete", ["id_orcamento"=> $id]);
    }

    public function atualizarOrcamento() {
        echo "Atualizar Orçamento";
    }

    public function deletarOrcamento() {
        echo "Deletar Orçamento";  
    }
}
?>
