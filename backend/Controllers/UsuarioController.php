<?php
namespace App\Misu\Controllers;

use App\Misu\Model\Usuario;
use App\Misu\Database\Database;
use App\Misu\Core\View;

class UsuarioController {
    public $usuario;
    public $db;
    public function __construct(){
        $this->db = Database::getInstance();
        $this->usuario = new Usuario($this->db);
   }

     // método - index
    public function index() {
        $resultado = $this->usuario->buscarUsuario();
        return $resultado;
       // var_dump ($resultado);
}


//30.09
    public function viewListarUsuarios() {
        View::render("usuario/index");
        
    }
    public function viewCriarUsuarios() {
        View::render("usuario/create");
        
    }
    public function viewEditarUsuarios() {
        View::render("usuario/edit");
        
    }
    public function viewExcluirUsuarios() {
        View::render("usuario/delete");
        
    }
    public function salvarUsuarios() {
        echo "Salvar Usuarios";
        
    }
    public function atualizarUsuarios() {
        echo "atualizar Usuarios";
        
    }public function deletarUsuarios() {
        echo "deletar Usuarios";
        
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
        }