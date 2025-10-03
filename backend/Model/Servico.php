<?php

namespace App\Misu\Model;

use PDO;

/* Executa uma instrução preparada passando um array de valores */
class Servico{
    private $id_servico;
    private $id_categoria;
    private $nome_servico;
    private $email_servico;
    private $tipo_servico;
    private $senha_servico;
    private $status_servico;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    //construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }
 
/* Executa uma instrução preparada passando um array de valores */
function buscarServico($db){
   
    $sql = 'SELECT nome_servico, email_servico FROM tbl_servico';
    $statment = $db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $statment->execute();
    return $resultado = $statment->fetchAll();
 
}
function buscarServicoPorEmail($db,$email){
    $sql = 'SELECT nome_servico, email_servico FROM tbl_servico WHERE email_servico = :email';
    $statment = $db->prepare($sql);
    $statment->bindParam(':email', $email);
    $statment->execute();
    return $resultado = $statment->fetchAll();
   
}
function registrarServico($db, $nome, $email, $senha){
    $sql = 'INSERT INTO tbl_servico (nome_servico, email_servico, senha_servico)
    VALUES (:nome, :email, :senha)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha',password_hash( $senha, PASSWORD_bCRYPT));
    $stmt->bindParam(':tipo', $tipo_servico);
    $stmt->bindParam(':status', $status_servico);
    if($stmt->execute()){
        return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
function atualizarServico($id, $nome, $email, $senha = null, $tipo = null, $status = null){
        $sql = "UPDATE tbl_servico SET nome_servico = :nome, email_servico = :email";
        if($senha){
            $sql .= ", senha_servico = :senha";
        }
        if($tipo){
            $sql .= ", tipo_servico = :tipo";
        }
        if($status){
            $sql .= ", status_servico = :status";
        }
        $sql .= ", atualizado_em = NOW() WHERE id_servico = :id";
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
    function deletarServico($id){
        $sql = "UPDATE tbl_servico SET excluido_em = NOW() WHERE id_servico = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
function buscarServicosPorId($db,$id){
    $sql = 'SELECT nome_servico, email_servico FROM tbl_servico WHERE id_servico = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
   
}

//19/09
 
//metodo de inativar o servico delete
function inativarServico($id){
    $dataatual = date('Y-m-d H:i:s');
    $sql = "UPDATE tbl_servico SET excluido_em = :atual WHERE id_servico = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if ($stmt->execute()){
    return true;
    } else {
        return false;
    };
}

//metodo de ativar o servico excluido read
function ativarServico($id){
    $sql = "UPDATE tbl_servico SET excluido_em = :atual WHERE id_servico = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if ($stmt->execute()){
        return true;
    } else {
        return false;
    };
}
// metodo de buscar todos os servicos
function buscarTodosServicos(){
    $sql = "SELECT * FROM tbl_servico WHERE excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// servicos inativos
function buscarTodosServicosInativos(){
    $sql = "SELECT * FROM tbl_servico WHERE excluido_em IS NOT NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}