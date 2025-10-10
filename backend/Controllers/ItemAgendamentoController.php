<?php
namespace App\Misu\Controllers;

use App\Misu\Model\ItemAgendamento;
use App\Misu\Database\Database;
use App\Misu\Core\View;
use App\Misu\Core\Redirect;
use App\Misu\Validadores\ItemAgendamentoValidador;

class ItemAgendamentoController {
    public $item;
    public $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->item = new ItemAgendamento($this->db);
    }

    public function salvarItem() {
        $erros = ItemAgendamentoValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("item_agendamento/criar","error", implode("<br>", $erros));
        }

        if($this->item->registrarItem(
            $_POST["id_agendamento"],
            $_POST["id_servico"],
            $_POST["id_cliente"],
            $_POST["valor_servico"],
            $_POST["quantidade_solicitada"],
            $_POST["descricao_item_item_agendamento"],
            $_POST["total_item"],
            $_POST["status_item_item_agendamento"]
        )){
            Redirect::redirecionarComMensagem("item_agendamento/listar","success","Item cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("item_agendamento/criar","error","Erro ao cadastrar item!");
        }
    }

    public function index() {
        $resultado = $this->item->buscarItens();
        var_dump($resultado);
    }

    public function viewListarItens($pagina) {
        $dados = $this->item->paginacao($pagina);
        $total = $this->item->totalDeItensAgendamento();
        View::render("item_agendamento/index", [
            "itens"=> $dados,
            "total_itens"=> $total[0],
            "total_inativos" => 22,
            "total_ativos" => 12
        ]);
    }

    public function viewCriarItem() {
        View::render("item_agendamento/create");
    }

    public function viewEditarItem($id) {
        $dados = $this->item->buscarItemPorId($id);
        foreach($dados as $item){
            $dados = $item;
        }
        View::render("item_agendamento/edit", ["item"=> $dados]);
    }

    public function viewExcluirItem($id){
        View::render("item_agendamento/delete", ["id_item_agendamento"=> $id]);
    }

    public function atualizarItem() {
        echo "Atualizar Item Agendamento";
    }

    public function deletarItem() {
        echo "Deletar Item Agendamento";  
    }
}
?>
