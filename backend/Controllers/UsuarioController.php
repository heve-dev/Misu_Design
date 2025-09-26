<?php
namespace App\Misu\Controllers;
use App\Misu\Model\Usuario;

class UsuarioController {
    public $usuarioModel;
   public function __construct() {
       $this->usuarioModel = new Usuario();
    }
    public function listar() {
       $resultado = $this->usuarioModel->buscarTodosUsuarios();
       var_dump($resultado[1]['email_usuario']);
    }
     public function textoParaMaiusculo() {
            $resultado = $this->usuarioModel->buscarTexto();
         //          str to upper
         $resultado = strtoupper($resultado);
         echo ($resultado);
     }
    public function textoParaMinusculo() {
        $resultado = $this->usuarioModel->buscarTexto();
        //          str to lower
        $resultado = ltrim(strtolower($resultado));
        echo ($resultado);
     }
      public function limparTexto() {
        $resultado = $this->usuarioModel->buscarTexto();
        //          trocar caracteres por outros
        $resultado = str_replace(",","-", $resultado);
        echo ($resultado);
     }
     public function converterEmArray() {
        $resultado = $this->limparTexto();
        //          converter string em array
        $resultado = explode(" ", $resultado);
        var_dump($resultado);
     }
     public function retornaPosicao($posicao){
            $resultado = $this->limparTexto();
            $resultado = explode(" ", $resultado);
            //          retorna a posição do array
            echo $resultado[$posicao];
        }
}