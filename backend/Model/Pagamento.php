<?php


require_once __DIR__.'/../Config/Database.php';
require_once __DIR__.'/../Model/usuario.php';
require_once __DIR__.'/../Model/Config.php';
$usuario = new Usuario($db);
$pagamento = new Pagamento($db);


include_once 'backend/database/database.php';
include_once 'backend/model/pagamento.php';


/* Executa uma instrução preparada passando um array de valores */
class Pagamento{
    private $id_pagamento;
    private $nome_pagamento;
    private $email_pagamento;
    private $tipo_pagamento;
    private $senha_pagamento;
    private $status_pagamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    //construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }
 
/* Executa uma instrução preparada passando um array de valores */

function buscarPagamento($db){
    $sql = 'SELECT id_pagamento, nome_pagamento, email_pagamento FROM tbl_pagamento ';
    $statment = $db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $statment->execute();
    return $resultado = $statment->fetchAll();

}

function buscarPagamentoPorId($db, $id){
    $sql = 'SELECT id_pagamento, nome_pagamento, email_pagamento FROM tbl_pagamento WHERE id_pagamento = :id';
    $statment = $db->prepare($sql);
    $statment->bindParam(':$id', $id); 
    return $statment->execute();
}

function registrarPagamento($db, $nome, $email){
    $sql = 'INSERT INTO tbl_pagamento (nome_pagamento, email_pagamento) 
    VALUES (:nome, :email)';
    $statment = $db->prepare($sql);
    $statment->bindParam(':nome', $nome); 
    $statment->bindParam(':email', $email);
    return $statment->execute();
    if($stmt->execute()){
        return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
}

function atualizarPagamento($id, $nome, $email, $senha = null, $tipo = null, $status = null){
        $sql = "UPDATE tbl_pagamento SET nome_pagamento = :nome, email_pagamento = :email";
        if($senha){
            $sql .= ", senha_pagamento = :senha";
        }
        if($tipo){
            $sql .= ", tipo_pagamento = :tipo";
        }
        if($status){
            $sql .= ", status_pagamento = :status";
        }
        $sql .= ", atualizado_em = NOW() WHERE id_pagamento = :id";
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
    function deletarPagamento($id){
        $sql = "UPDATE tbl_pagamento SET excluido_em = NOW() WHERE id_pagamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
function buscarPagamentosPorId($db,$id){
    $sql = 'SELECT nome_pagamento, email_pagamento FROM tbl_pagamento WHERE id_pagamento = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
   
}

//19/09
 
//metodo de inativar o pagamento delete
function inativarPagamento($id){
    $dataatual = date('Y-m-d H:i:s');
    $sql = "UPDATE tbl_pagamento SET excluido_em = :atual WHERE id_pagamento = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if ($stmt->execute()){
    return true;
    } else {
        return false;
    };
}

//metodo de ativar o pagamento excluido read
function ativarPagamento($id){
    $sql = "UPDATE tbl_pagamento SET excluido_em = :atual WHERE id_pagamento = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if ($stmt->execute()){
        return true;
    } else {
        return false;
    };
}
// metodo de buscar todos os pagamentos
function buscarTodosPagamentos(){
    $sql = "SELECT * FROM tbl_pagamento WHERE excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// pagamentos inativos
function buscarTodosPagamentosInativos(){
    $sql = "SELECT * FROM tbl_pagamento WHERE excluido_em IS NOT NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
//metodo de buscar pagamento por email read
function buscarPagamentoPorEmail($email){
    $sql = "SELECT * FROM tbl_pagamento WHERE email_pagamento = :email AND excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
// emails inativos read
function buscarPagamentoPorEmailInativo($email){
    $sql = "SELECT * FROM tbl_pagamento WHERE email_pagamento = :email AND excluido_em IS NOT NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


