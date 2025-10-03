<?php
namespace App\Misu\Controllers;

use App\Misu\Model\Usuario;
use App\Misu\Database\Database;
use App\Misu\Core\View;
use App\Misu\Core\Redirect;
use App\Misu\Validadores\UsuarioValidador;

class UsuarioController {
    public $usuario;
    public $db;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->usuario = new Usuario($this->db);
    }

     // método - index
    public function index() {
        $resultado = $this->usuario->buscarUsuario();
        var_dump ($resultado);
}


//30.09
  //raiz do array
   public function viewListarUsuarios(){
        $dados = $this->usuario->buscarUsuario();
        View::render("usuario/index", ["usuarios"=> $dados] );
    }
//---  VIEWS
    public function viewCriarUsuario() {
        View::render("usuario/create");
        
    }
    public function viewEditarUsuario() {
        View::render("usuario/edit");
        
    }
    public function viewExcluirUsuario() {
        View::render("usuario/delete");
        
    }

// ---
    public function salvarUsuario() {
       $erros = UsuarioValidador::ValidarEntradas($_POST);
       if(!empty($erros)){
            Redirect::redirecionarComMensagem("usuario/criar","error", implode("<br>", $erros));
       }
        if($this->usuario->inserirUsuario(
            $_POST["nome_usuario"],
            $_POST["email_usuario"],
            $_POST["senha_usuario"],
            $_POST["tipo_usuario"],
            "Ativo"
        )){
            Redirect::redirecionarComMensagem("usuario/listar","success","Usuário cadastrado com sucesso!");
        }else{
            Redirect::redirecionarComMensagem("usuario/criar","error","Erro ao cadastrar usuário!");
        }
        
    }
    public function atualizarUsuarios() {
        echo "atualizar Usuarios";
        
    }public function deletarUsuarios() {
        echo "deletar Usuarios";
        
    }

}
