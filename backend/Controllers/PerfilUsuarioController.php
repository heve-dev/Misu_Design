<?php
namespace App\Misu\Controllers;

use App\Misu\Model\PerfilUsuario;
use App\Misu\Database\Database;
use App\Misu\Core\View;
use App\Misu\Core\Redirect;
use App\Misu\Validadores\PerfilUsuarioValidador;

class PerfilUsuarioController {
    public $perfil;
    public $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->perfil = new PerfilUsuario($this->db);
    }

    public function salvarPerfil() {
        $erros = PerfilUsuarioValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("perfil/criar","error", implode("<br>", $erros));
        }

        if($this->perfil->registrarPerfil(
            $_POST["id_usuario"],
            $_POST["descricao_perfil_usuario"],
            $_POST["foto_perfil_usuario"] ?? null,
            $_POST["banner_perfil_usuario"] ?? null,
            "Ativo"
        )){
            Redirect::redirecionarComMensagem("perfil/listar","success","Perfil cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("perfil/criar","error","Erro ao cadastrar perfil!");
        }
    }

    public function index() {
        $resultado = $this->perfil->buscarPerfisAtivos();
        var_dump($resultado);
    }

    public function viewListarPerfis($pagina) {
        $dados = $this->perfil->paginacao($pagina);
        $total = $this->perfil->totalDePerfis();
        View::render("perfil/index", [
            "perfis"=> $dados,
            "total_perfis"=> $total[0],
            "total_inativos" => 22,
            "total_ativos" => 12
        ]);
    }

    public function viewCriarPerfil() {
        View::render("perfil/create");
    }

    public function viewEditarPerfil($id) {
        $dados = $this->perfil->buscarPerfilPorId($id);
        foreach($dados as $perfil){
            $dados = $perfil;
        }
        View::render("perfil/edit", ["perfil"=> $dados]);
    }

    public function viewExcluirPerfil($id){
        View::render("perfil/delete", ["id_perfil_usuario"=> $id]);
    }

    public function atualizarPerfil() {
        echo "Atualizar Perfil";
    }

    public function deletarPerfil() {
        echo "Deletar Perfil";  
    }
}
?>
