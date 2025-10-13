<?php
namespace App\Misu\Controllers;

use App\Misu\Model\Usuario;
use App\Misu\Database\Database;
use App\Misu\Core\View;
use App\Misu\Core\Redirect;
use App\Misu\Validadores\UsuarioValidador;
use App\Misu\Core\FileManager;

class UsuarioController {
    public $usuario;
    public $db;
    public $gerenciarImagem;
    public function __construct() {
      
        $this->db = Database::getInstance();
        $this->usuario = new Usuario($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }
    public function salvarUsuarios() {
       $erros = UsuarioValidador::ValidarEntradas($_POST);
       if(!empty($erros)){
            Redirect::redirecionarComMensagem("usuario/criar","error", implode("<br>", $erros));
       }
       //novo caminho
        $imagem = $this->gerenciarImagem->salvarArquivo($_FILES['imagem'], 'usuario');
        if($this->usuario->registrarUsuarios(
            $_POST["nome_usuario"],
            $_POST["email_usuario"],
            $_POST["senha_usuario"],
            $_POST["tipo_usuario"],
            "Ativo",
            $imagem
        )){
            Redirect::redirecionarComMensagem("usuario/listar","success","Usuário cadastrado com sucesso!");
        }else{
            Redirect::redirecionarComMensagem("usuario/criar","error","Erro ao cadastrar usuário!");
        }
    }

     // método - index
    public function index() {
        $resultado = $this->usuario->buscarUsuarios();
       echo "Cheguei";
}

  //raiz do array
   public function viewListarUsuarios($pagina){
        $dados = $this->usuario->paginacao($pagina);
        $total = $this->usuario->totalDeUsuarios();
        View::render("usuario/index", 
        [
        "usuarios"=> $dados,
         "total_usuarios"=> $total[0],
         "total_inativos" => 22,
         "Total_ativos" => 12
        ] 
        );
    }
//---  VIEWS
// View Criar---------------
    public function viewCriarUsuarios() {
       
        View::render("usuario/create");
    }
// View Editar---------------
    public function viewEditarUsuarios($id) {
         $dados = $this->usuario->buscarUsuariosPorId($id);
        foreach($dados as $usuario){
                $dados = $usuario;
        }
        View::render("usuario/edit", ["usuario"=> $dados ]);
    }
// View Excluir---------------

    public function viewExcluirUsuarios($id){
       View::render("usuario/delete", ["id_usuario"=> $id ]);
    }
// View Relatorio---------------
    public function relatorioUsuarios($id, $data_inicio, $data_fim) {
        View::render("usuario/details", 
        ["id"=> $id, "data_inicio"=> $data_inicio, "data_fim"=> $data_fim]);
    }

// ---------------
// Atualizar---------------
    public function atualizarUsuarios() {
        echo "Atualizar Usuarios";
    }
// Deletar---------------
    public function deletarUsuarios() {
        echo "Deletar Usuarios";  
    }
}