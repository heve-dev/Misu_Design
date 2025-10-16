<?php
namespace App\Misu\Controllers;

use App\Misu\Model\Agendamento;
use App\Misu\Database\Database;
use App\Misu\Core\View;
use App\Misu\Core\Redirect;
use App\Misu\Validadores\AgendamentoValidador;

class AgendamentoController {
    public $agendamento;
    public $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->agendamento = new Agendamento($this->db);
    
        if($this->agendamento->registrarAgendamento(
            $_POST["id_cliente"],
            $_POST["id_servico"],
            $_POST["data_solicitada"],
            $_POST["total_agendamento"],
            $_POST["status_agendamento"]
        )){
            Redirect::redirecionarComMensagem("agendamento/listar","success","Agendamento cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("agendamento/criar","error","Erro ao cadastrar agendamento!");
        }
    }

    public function index() {
        $resultado = $this->agendamento->buscarAgendamentosAtivos();
        var_dump($resultado);
    }

    public function viewListarAgendamentos($pagina) {
        $dados = $this->agendamento->paginacao($pagina);
        $total = $this->agendamento->totalDeAgendamentos();
        View::render("agendamento/index", [
            "agendamentos"=> $dados,
            "total_agendamentos"=> $total[0],
            "total_inativos" => 22,
            "total_ativos" => 12
        ]);
    }

    public function viewCriarAgendamento() {
        View::render("agendamento/create");
    }

    public function viewEditarAgendamento($id) {
        $dados = $this->agendamento->buscarAgendamentoPorId($id);
        foreach($dados as $agendamento){
            $dados = $agendamento;
        }
        View::render("agendamento/edit", ["agendamento"=> $dados]);
    }

    public function viewExcluirAgendamento($id){
        View::render("agendamento/delete", ["id_agendamento"=> $id]);
    }

      public function salvarAgendamento() {
        $erros = AgendamentoValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("agendamento/criar","error", implode("<br>", $erros));
        }
    }
    public function atualizarAgendamento() {
        echo "Atualizar Agendamento";
    }

    public function deletarAgendamento() {
        echo "Deletar Agendamento";  
    }
}

?>
