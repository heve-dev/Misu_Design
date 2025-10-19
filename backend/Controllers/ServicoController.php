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
        var_dump($_POST); exit;
        $erros = ServicoValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("servico/criar","error", implode("<br>", $erros));
        }

        $imagem = $this->gerenciarImagem->salvarArquivo($_FILES['imagem'], 'servico');
        if($this->servico->registrarServicos(
            $_POST["nome_servico"],
            $_POST["descricao_servico"],
            $_POST["valor_servico"],
            $_POST["foto_servico"],
            $_POST["status_servico"],
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
        $resultado = $this->servico->totalDeServicos();
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
//---  VIEWS
    // View criar
    public function viewCriarServicos() {
        
        $categorias = $this->servico->listarCategorias();
        
        View::render("servico/create", ["categorias"=> $categorias]);
    }

    // View editar
    public function viewEditarServicos($id) {
        $dados = $this->servico->buscarServicosPorId($id);
        foreach($dados as $servico){
            $dados = $servico;
        }
        View::render("servico/edit", ["servico"=> $dados]);
    }

    // View excluir
    public function viewExcluirServicos($id){
        View::render("servico/delete", ["id_servico"=> $id]);
    }

  
    // View Relatorio---------------
    public function relatorioUsuarios($id, $data_inicio, $data_fim) {
        View::render("usuario/details", 
        ["id"=> $id, "data_inicio"=> $data_inicio, "data_fim"=> $data_fim]);
    }

      // Atualizar
    public function atualizarServicos() {
        echo "Atualizar Serviço";
    }

    // Deletar
    public function deletarServicos() {
        echo "Deletar Serviço";  
    }
}

?>
