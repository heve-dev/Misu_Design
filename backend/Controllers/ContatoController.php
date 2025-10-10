<?php
namespace App\Misu\Controllers;

use App\Misu\Model\Contato;
use App\Misu\Database\Database;
use App\Misu\Core\View;
use App\Misu\Core\Redirect;
use App\Misu\Validadores\ContatoValidador;

class ContatoController {
    public $contato;
    public $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->contato = new Contato($this->db);
    }

    public function salvarContato() {
        $erros = ContatoValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("contato/criar","error", implode("<br>", $erros));
        }

        if($this->contato->registrarContato(
            $_POST["nome_contato"],
            $_POST["telefone_contato"],
            $_POST["email_contato"],
            $_POST["mensagem_contato"],
            "Ativo"
        )){
            Redirect::redirecionarComMensagem("contato/listar","success","Contato cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("contato/criar","error","Erro ao cadastrar contato!");
        }
    }

    public function index() {
        $resultado = $this->contato->buscarContatos();
        var_dump($resultado);
    }

    public function viewListarContatos($pagina) {
        $dados = $this->contato->paginacao($pagina);
        $total = $this->contato->totalDeContatos();
        View::render("contato/index", [
            "contatos"=> $dados,
            "total_contatos"=> $total[0],
            "total_inativos" => 22,
            "total_ativos" => 12
        ]);
    }

    public function viewCriarContato() {
        View::render("contato/create");
    }

    public function viewEditarContato($id) {
        $dados = $this->contato->buscarContatoPorId($id);
        foreach($dados as $contato){
            $dados = $contato;
        }
        View::render("contato/edit", ["contato"=> $dados]);
    }

    public function viewExcluirContato($id){
        View::render("contato/delete", ["id_contato"=> $id]);
    }

    public function atualizarContato() {
        echo "Atualizar Contato";
    }

    public function deletarContato() {
        echo "Deletar Contato";  
    }
}
?>
