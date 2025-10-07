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
        $resultado = $this->usuario->buscarUsuarios();
        var_dump ($resultado);
}


//30.09
  //raiz do array
   public function viewListarUsuarios(){
        $dados = $this->usuario->buscarUsuarios();
        View::render("usuario/index", ["usuarios"=> $dados] );
    }
//---  VIEWS
    public function viewCriarUsuario() {
        View::render("usuario/create");
        
    }
    public function viewEditarUsuario($id) {
        View::render("usuario/edit", ["id_usuario"=> $id ]);
        
    }
    public function viewExcluirUsuario($id) {
        View::render("usuario/delete", ["id_usuario"=> $id ]);
        
    }
    public function relatorioUsuario($id, $data_inicio, $data_fim) {
        View::render("usuario/details", ["id"=> $id ]);
    }
// ---
    public function salvarUsuarios() {
       $erros = UsuarioValidador::ValidarEntradas($_POST);
       if(!empty($erros)){
            Redirect::redirecionarComMensagem("usuario/criar","error", implode("<br>", $erros));
       }
        if($this->usuario->registrarUsuarios(
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

//outrodiasla
        //view - ao ter o GET vai exibir a pagina


        // public function viewCriarUsuarios(){
        //  echo "Listar Usuarios";
        // }
        // public function viewListarUsuarios(){
        //  echo "Listar Usuarios";
        // }
        // public function viewEditarUsuarios(){
        //     echo "Listar Usuarios";
        // }
        // public function viewExcluirUsuarios(){
        //     echo "Listar Usuarios";
        // }
        // // vão executar e serão chamados pelo formulario


        // public function salvarUsuarios(){
        //     echo "Listar Usuarios";
        // }
        // public function atuzalizarUsuarios(){
        //     echo "Listar Usuarios";
        // }
        // public function deletarUsuarios(){
        //     echo "Listar Usuarios";
        // }






   // // método - listar
    // public function listar() {
    //    $resultado = $this->usuarioModel->buscarTodosUsuarios();
    //    var_dump($resultado[1]['email_usuario']);
    // }
   
    //  public function textoParaMaiusculo() {
    //         $resultado = $this->usuarioModel->buscarTexto();
    //      //          str to upper
    //      $resultado = strtoupper($resultado);
    //      echo ($resultado);
    //  }
    // public function textoParaMinusculo() {
    //     $resultado = $this->usuarioModel->buscarTexto();
    //     //          str to lower
    //     $resultado = ltrim(strtolower($resultado));
    //     echo ($resultado);
    //  }
    //   public function limparTexto() {
    //     $resultado = $this->usuarioModel->buscarTexto();
    //     //          trocar caracteres por outros
    //     $resultado = str_replace(",","-", $resultado);
    //     echo ($resultado);
    //  }
    //  public function converterEmArray() {
    //     $resultado = $this->limparTexto();
    //     //          converter string em array
    //     $resultado = explode(" ", $resultado);
    //     var_dump($resultado);
    //  }
    //  public function retornaPosicao($posicao){
    //         $resultado = $this->limparTexto();
    //         $resultado = explode(" ", $resultado);
    //         //          retorna a posição do array
    //         echo $resultado[$posicao];
    //     }

    //     // adc da ia
    //    public function juntarArray() {
    //            $resultado = $this->limparTexto();
    //            $resultado = explode(" ", $resultado);
    //            //          juntar array em string
    //            $resultado = implode(" ", $resultado);
    //            echo ($resultado);
    //      }