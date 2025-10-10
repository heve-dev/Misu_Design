<?php
namespace App\Misu\Controllers;

use App\Misu\Model\Servico;
use App\Misu\Database\Database;
use App\Misu\Core\View;
use App\Misu\Core\Redirect;
use App\Misu\Validadores\ServicoValidador;
use App\Misu\Core\FileManager;

class ServicoController {
    public $servico;
    public $db;
    public $gerenciarImagem;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->servico = new Servico($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }

    // Salvar novo serviço
    public function salvarServicos() {
        $erros = ServicoValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("servico/criar","error", implode("<br>", $erros));
        }

        $imagem = $this->gerenciarImagem->salvarArquivo($_FILES['imagem'], 'servico');
        if($this->servico->criarServicos(
            $_POST["nome_servico"],
            $_POST["descricao_servico"],
            $_POST["valor_servico"],
            $imagem,
            "Ativo"
        )){
            Redirect::redirecionarComMensagem("servico/listar","success","Serviço cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("servico/criar","error","Erro ao cadastrar serviço!");
        }
    }

    // Index
    public function index() {
        $resultado = $this->servico->buscarServicos();
        var_dump($resultado);
    }

    // Listar serviços paginados
    public function viewListarServicos($pagina) {
        $dados = $this->servico->paginacao($pagina);
        $total = $this->servico->totalDeServicos();
        View::render("servico/index", [
            "servicos"=> $dados,
            "total_servicos"=> $total[0],
            "total_inativos" => 22,
            "total_ativos" => 12
        ]);
    }

    // View criar
    public function viewCriarServico() {
        View::render("servico/create");
    }

    // View editar
    public function viewEditarServico($id) {
        $dados = $this->servico->buscarServicosPorId($id);
        foreach($dados as $servico){
            $dados = $servico;
        }
        View::render("servico/edit", ["servico"=> $dados]);
    }

    // View excluir
    public function viewExcluirServico($id){
        View::render("servico/delete", ["id_servico"=> $id]);
    }

    // Atualizar
    public function atualizarServico() {
        echo "Atualizar Serviço";
    }

    // Deletar
    public function deletarServico() {
        echo "Deletar Serviço";  
    }
}
?>
