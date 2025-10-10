<?php
namespace App\Misu\Controllers;

use App\Misu\Model\Categoria;
use App\Misu\Database\Database;
use App\Misu\Core\View;
use App\Misu\Core\Redirect;
use App\Misu\Validadores\CategoriaValidador;
use App\Misu\Core\FileManager;

class CategoriaController {
    public $categoria;
    public $db;
    public $gerenciarImagem;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->categoria = new Categoria($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }

    public function salvarCategoria() {
        $erros = CategoriaValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("categoria/criar","error", implode("<br>", $erros));
        }

        $imagem = $this->gerenciarImagem->salvarArquivo($_FILES['imagem'], 'categoria');
        if($this->categoria->registrarCategoria(
            $_POST["nome_categoria"],
            $_POST["descricao_categoria"],
            $imagem
        )){
            Redirect::redirecionarComMensagem("categoria/listar","success","Categoria cadastrada com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("categoria/criar","error","Erro ao cadastrar categoria!");
        }
    }

    public function index() {
        $resultado = $this->categoria->buscarCategorias();
        var_dump($resultado);
    }

    public function viewListarCategorias($pagina) {
        $dados = $this->categoria->paginacao($pagina);
        $total = $this->categoria->totalDeCategorias();
        View::render("categoria/index", [
            "categorias"=> $dados,
            "total_categorias"=> $total[0],
            "total_inativos" => 22,
            "total_ativos" => 12
        ]);
    }

    public function viewCriarCategoria() {
        View::render("categoria/create");
    }

    public function viewEditarCategoria($id) {
        $dados = $this->categoria->buscarCategoriaPorId($id);
        foreach($dados as $categoria){
            $dados = $categoria;
        }
        View::render("categoria/edit", ["categoria"=> $dados]);
    }

    public function viewExcluirCategoria($id){
        View::render("categoria/delete", ["id_categoria"=> $id]);
    }

    public function atualizarCategoria() {
        echo "Atualizar Categoria";
    }

    public function deletarCategoria() {
        echo "Deletar Categoria";  
    }
}
?>
