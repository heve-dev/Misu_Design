<?php
namespace App\Misu\Controllers;

use App\Misu\Model\ItemOrcamento;
use App\Misu\Database\Database;
use App\Misu\Core\View;
use App\Misu\Core\Redirect;
use App\Misu\Validadores\ItemOrcamentoValidador;

class ItemOrcamentoController {
    public $item;
    public $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->item = new ItemOrcamento($this->db);
    }

    public function salvarItem() {
        $erros = ItemOrcamentoValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("item_orcamento/criar","error", implode("<br>", $erros));
        }

        if($this->item->registrarItem(
            $_POST["id_orcamento"],
            $_POST["id_servico"],
            $_POST["id_cliente"],
            $_POST["valor_servico"],
            $_POST["quantidade_solicitada"],
            $_POST["descricao_item_orcamento"],
            $_POST["total_item_orcamento"],
            $_POST["status_item_orcamento"]
        )){
            Redirect::redirecionarComMensagem("item_orcamento/listar","success","Item cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("item_orcamento/criar","error","Erro ao cadastrar item!");
        }
    }

    public function index() {
        $resultado = $this->item->buscarItens();
        var_dump($resultado);
    }

    public function viewListarItens($pagina) {
        $dados = $this->item->paginacao($pagina);
        $total = $this->item->totalDeItens();
        View::render("item_orcamento/index", [
            "itens"=> $dados,
            "total_itens"=> $total[0],
            "total_inativos" => 22,
            "total_ativos" => 12
        ]);
    }

    public function viewCriarItem() {
        View::render("item_orcamento/create");
    }

    public function viewEditarItem($id) {
        $dados = $this->item->buscarItemPorId($id);
        foreach($dados as $item){
            $dados = $item;
        }
        View::render("item_orcamento/edit", ["item"=> $dados]);
    }

    public function viewExcluirItem($id){
        View::render("item_orcamento/delete", ["id_item_orcamento"=> $id]);
    }

    public function atualizarItem() {
        echo "Atualizar Item";
    }

    public function deletarItem() {
        echo "Deletar Item";  
    }
}
?>
