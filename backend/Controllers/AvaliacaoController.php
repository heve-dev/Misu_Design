<?php
namespace App\Misu\Controllers;

use App\Misu\Model\Avaliacao;
use App\Misu\Database\Database;
use App\Misu\Core\View;
use App\Misu\Core\Redirect;
use App\Misu\Validadores\AvaliacaoValidador;

class AvaliacaoController {
    public $avaliacao;
    public $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->avaliacao = new Avaliacao($this->db);
    }

    public function salvarAvaliacao() {
        $erros = AvaliacaoValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("avaliacao/criar","error", implode("<br>", $erros));
        }

        if($this->avaliacao->registrarAvaliacao(
            $_POST["id_cliente"],
            $_POST["id_servico"],
            $_POST["descricao_avaliacao"],
            $_POST["nota_avaliacao"],
            $_POST["status_avaliacao"]
        )){
            Redirect::redirecionarComMensagem("avaliacao/listar","success","Avaliação cadastrada com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("avaliacao/criar","error","Erro ao cadastrar avaliação!");
        }
    }

    public function index() {
        $resultado = $this->avaliacao->buscarAvaliacoes();
        var_dump($resultado);
    }

    public function viewListarAvaliacoes($pagina) {
        $dados = $this->avaliacao->paginacao($pagina);
        $total = $this->avaliacao->totalDeAvaliacoes();
        View::render("avaliacao/index", [
            "avaliacoes"=> $dados,
            "total_avaliacoes"=> $total[0],
            "total_inativos" => 22,
            "total_ativos" => 12
        ]);
    }

    public function viewCriarAvaliacao() {
        View::render("avaliacao/create");
    }

    public function viewEditarAvaliacao($id) {
        $dados = $this->avaliacao->buscarAvaliacaoPorId($id);
        foreach($dados as $avaliacao){
            $dados = $avaliacao;
        }
        View::render("avaliacao/edit", ["avaliacao"=> $dados]);
    }

    public function viewExcluirAvaliacao($id){
        View::render("avaliacao/delete", ["id_avaliacao"=> $id]);
    }

}
