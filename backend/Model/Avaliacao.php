<?php

require_once __DIR__.'/../Config/Database.php';
require_once __DIR__.'/../Model/usuario.php';
require_once __DIR__.'/../Model/Config.php';
$usuario = new Usuario($db);
$avaliacao = new Avaliacao($db);

/* Executa uma instrução preparada passando um array de valores */
class Avaliacao{
    private $id_avaliacao;
    private $nome_avaliacao;
    private $email_avaliacao;
    private $tipo_avaliacao;
    private $senha_avaliacao;
    private $status_avaliacao;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    //construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }
 
/* Executa uma instrução preparada passando um array de valores */
function buscarAvaliacao($db){
   
    $sql = 'SELECT nome_avaliacao, email_avaliacao FROM tbl_avaliacao';
    $statment = $db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $statment->execute();
    return $resultado = $statment->fetchAll();
 
}
function buscarAvaliacaoPorEmail($db,$email){
    $sql = 'SELECT nome_avaliacao, email_avaliacao FROM tbl_avaliacao WHERE email_avaliacao = :email';
    $statment = $db->prepare($sql);
    $statment->bindParam(':email', $email);
    $statment->execute();
    return $resultado = $statment->fetchAll();
   
}
function registrarAvaliacao($db, $nome, $email, $senha){
    $sql = 'INSERT INTO tbl_avaliacao (nome_avaliacao, email_avaliacao, senha_avaliacao)
    VALUES (:nome, :email, :senha)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha',password_hash( $senha, PASSWORD_bCRYPT));
    $stmt->bindParam(':tipo', $tipo_avaliacao);
    $stmt->bindParam(':status', $status_avaliacao);
    if($stmt->execute()){
        return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
function atualizarAvaliacao($id, $nome, $email, $senha = null, $tipo = null, $status = null){
        $sql = "UPDATE tbl_avaliacao SET nome_avaliacao = :nome, email_avaliacao = :email";
        if($senha){
            $sql .= ", senha_avaliacao = :senha";
        }
        if($tipo){
            $sql .= ", tipo_avaliacao = :tipo";
        }
        if($status){
            $sql .= ", status_avaliacao = :status";
        }
        $sql .= ", atualizado_em = NOW() WHERE id_avaliacao = :id";
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
    function deletarAvaliacao($id){
        $sql = "UPDATE tbl_avaliacao SET excluido_em = NOW() WHERE id_avaliacao = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
function buscarAvaliacaoPorID($db,$id){
    $sql = 'SELECT nome_avaliacao, email_avaliacao FROM tbl_avaliacao WHERE id_avaliacao = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
   
}

//19/09
 
//metodo de inativar o avaliacao delete
function inativarAvaliacao($id){
    $dataatual = date('Y-m-d H:i:s');
    $sql = "UPDATE tbl_avaliacao SET excluido_em = :atual WHERE id_avaliacao = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if ($stmt->execute()){
    return true;
    } else {
        return false;
    };
}

//metodo de ativar o avaliacao excluido read
function ativarAvaliacao($id){
    $sql = "UPDATE tbl_avaliacao SET excluido_em = :atual WHERE id_avaliacao = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if ($stmt->execute()){
        return true;
    } else {
        return false;
    };
}
// metodo de buscar todas as avaliacoes
function buscarTodosAvaliacao(){
    $sql = "SELECT * FROM tbl_avaliacao WHERE excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// avaliacoes inativas
function buscarTodosAvaliacaoInativos(){
    $sql = "SELECT * FROM tbl_avaliacao WHERE excluido_em IS NOT NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
//metodo de buscar avaliacao por email read
function buscarAvaliacaoPorEmail($email){
    $sql = "SELECT * FROM tbl_avaliacao WHERE email_avaliacao = :email AND excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
// emails inativos read
function buscarAvaliacaoPorEmailInativo($email){
    $sql = "SELECT * FROM tbl_avaliacao WHERE email_avaliacao = :email AND excluido_em IS NOT NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
