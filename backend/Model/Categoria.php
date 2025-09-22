<?php

require_once __DIR__.'/../Config/Database.php';
require_once __DIR__.'/../Model/usuario.php';
require_once __DIR__.'/../Model/Config.php';
$usuario = new Usuario($db);
$categoria = new Categoria($db);

/* Executa uma instrução preparada passando um array de valores */
class Categoria{
    private $id_categoria;
    private $nome_categoria;
    private $email_categoria;
    private $tipo_categoria;
    private $senha_categoria;
    private $status_categoria;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    //construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }
 
/* Executa uma instrução preparada passando um array de valores */
function buscarCategoria($db){
   
    $sql = 'SELECT nome_categoria, email_categoria FROM tbl_categoria';
    $statment = $db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $statment->execute();
    return $resultado = $statment->fetchAll();
 
}
function buscarCategoriaPorEmail($db,$email){
    $sql = 'SELECT nome_categoria, email_categoria FROM tbl_categoria WHERE email_categoria = :email';
    $statment = $db->prepare($sql);
    $statment->bindParam(':email', $email);
    $statment->execute();
    return $resultado = $statment->fetchAll();
   
}
function registrarCategoria($db, $nome, $email, $senha){
    $sql = 'INSERT INTO tbl_categoria (nome_categoria, email_categoria, senha_categoria)
    VALUES (:nome, :email, :senha)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha',password_hash( $senha, PASSWORD_bCRYPT));
    $stmt->bindParam(':tipo', $tipo_categoria);
    $stmt->bindParam(':status', $status_categoria);
    if($stmt->execute()){
        return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
function atualizarCategoria($id, $nome, $email, $senha = null, $tipo = null, $status = null){
        $sql = "UPDATE tbl_categoria SET nome_categoria = :nome, email_categoria = :email";
        if($senha){
            $sql .= ", senha_categoria = :senha";
        }
        if($tipo){
            $sql .= ", tipo_categoria = :tipo";
        }
        if($status){
            $sql .= ", status_categoria = :status";
        }
        $sql .= ", atualizado_em = NOW() WHERE id_categoria = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        if($senha){
            $stmt->bindParam(':senha', password_hash($senha, PASSWORD_BCRYPT));
        }
        if($tipo){
            $stmt->bindParam(':tipo', $tipo);
        }
        if($status){
            $stmt->bindParam(':status', $status);
        }
        return $stmt->execute();
    }
    function deletarCategoria($id){
        $sql = "UPDATE tbl_categoria SET excluido_em = NOW() WHERE id_categoria = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
function buscarCategoriasPorID($db,$id){
    $sql = 'SELECT nome_categoria, email_categoria FROM tbl_categoria WHERE id_categoria = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
   
}

//19/09
 
//metodo de inativar o categoria delete
function inativarCategoria($id){
    $dataatual = date('Y-m-d H:i:s');
    $sql = "UPDATE tbl_categoria SET excluido_em = :atual WHERE id_categoria = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if ($stmt->execute()){
    return true;
    } else {
        return false;
    };
}

//metodo de ativar o categoria excluido read
function ativarCategoria($id){
    $sql = "UPDATE tbl_categoria SET excluido_em = :atual WHERE id_categoria = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if ($stmt->execute()){
        return true;
    } else {
        return false;
    };
}
// metodo de buscar todos os categorias
function buscarTodosCategorias(){
    $sql = "SELECT * FROM tbl_categoria WHERE excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// categorias inativos
function buscarTodosCategoriasInativos(){
    $sql = "SELECT * FROM tbl_categoria WHERE excluido_em IS NOT NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}