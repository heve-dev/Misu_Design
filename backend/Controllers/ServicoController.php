<?php
namespace App\Misu\Controllers;

use App\Misu\Model\Servico;
use App\Misu\Database\Database;
use App\Misu\Core\View;
use App\Misu\Core\Redirect;
use App\Misu\Core\FileManager;
use App\Misu\Controllers\Admin\AdminController;

class ServicoController extends AdminController{
    public $servico;
    public $db;
    public $gerenciarImagem;

    public function __construct() {
        parent::__construct();
        $this->db = Database::getInstance();
        $this->servico = new Servico($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }


     public function index() {
        $this->viewListarServicos();
    }

    // Salvar novo serviço
    public function salvarServicos() {
         if (empty($_POST["nome_servico"]) || empty($_FILES['foto_servico']['name'])) {
            Redirect::redirecionarComMensagem("servico/criar", "error", "Nome e Foto são obrigatórios.");
        }
        $imagem = $this->gerenciarImagem->salvarArquivo($_FILES['imagem'], 'servico');
        if($this->servico->registrarServicos(
            $_POST["nome_servico"],
            $_POST["descricao_servico"],
            $_POST["valor_servico"],
            $_POST["foto_servico"],
            $_POST["status_servico"],
            $imagem,
        )){
            Redirect::redirecionarComMensagem("servico/listar","success","Serviço cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("servico/criar","error","Erro ao cadastrar serviço!");
        }
    }

        // Atualizar
    public function atualizarServicos() {
       
        $id = (int)$_POST['id_servico'];
        $categoria= $_POST['categoria_servico'];
        $nome = $_POST['nome_servico'];
        $descricao = $_POST['descricao_servico'];
        $valor = $_POST['valor_servico'];
        $foto = null;
        $status = $_POST['status_servico'];

        if (isset($_FILES['foto_servico']) && $_FILES['foto_servico']['error'] == 0 && !empty($_FILES['foto_servico']['name'])) {
            $foto = $this->gerenciarImagem->salvarArquivo($_FILES['foto_servico'], 'servicos');
        }

        if ($this->servico->atualizarServicos($id, $categoria, $nome, $descricao, $valor, $foto, $status)) {
            Redirect::redirecionarComMensagem("servico/listar", "success", "Serviço atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("servico/editar/" . $id, "error", "Erro ao atualizar serviço.");
        }
    }

    // Deletar
    public function deletarServicos() {
        $id = (int)$_POST['id_servico'];
        if ($this->servico->deletarServicos($id)) {
            Redirect::redirecionarComMensagem("servico/listar", "success", "Serviço inativado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("servico/listar", "error", "Erro ao inativar serviço.");
        } 
    }


//---  VIEWS

    // View listar
    public function viewListarServicos($pagina = 1) {
        if (empty($pagina) || $pagina <= 0) $pagina = 1;
        
        $dados = $this->servico->paginacao($pagina, 50);
        
        View::render("servico/index", [
            "servicos" => $dados['data'],
            'paginacao' => $dados
        ]);
    }

    // View criar
    public function viewCriarServicos() { 
        $categorias = $this->servico->listarCategorias();
        View::render("servico/create", ["categorias"=> $categorias]);
    }

    // View editar
    public function viewEditarServicos(int $id) {
        $servico = $this->servico->buscarServicosPorID($id);
        if (!$servico) {
            Redirect::redirecionarComMensagem("servico/listar", "error", "Serviço não encontrado.");
        }
        
        View::render("servico/edit", ["servico" => $servico]);
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

}

?>
