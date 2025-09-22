<?php

require_once __DIR__.'/../Config/Database.php';
require_once __DIR__.'/../Model/usuario.php';
require_once __DIR__.'/../Model/Config.php';
$usuario = new Usuario($db);
$orcamento = new Orcamento($db);

/* Executa uma instrução preparada passando um array de valores */
class Orcamento{
    private $id_orcamento;
    private $nome_orcamento;
    private $email_orcamento;
    private $tipo_orcamento;
    private $senha_orcamento;
    private $status_orcamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    //construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }
 
/* Executa uma instrução preparada passando um array de valores */
function buscarOrcamento($db){
   
    $sql = 'SELECT nome_orcamento, email_orcamento FROM tbl_orcamento';
    $statment = $db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $statment->execute();
    return $resultado = $statment->fetchAll();
 
}
function buscarOrcamentoPorEmail($db,$email){
    $sql = 'SELECT nome_orcamento, email_orcamento FROM tbl_orcamento WHERE email_orcamento = :email';
    $statment = $db->prepare($sql);
    $statment->bindParam(':email', $email);
    $statment->execute();
    return $resultado = $statment->fetchAll();
   
}
function registrarOrcamento($db, $nome, $email, $senha){
    $sql = 'INSERT INTO tbl_orcamento (nome_orcamento, email_orcamento, senha_orcamento)
    VALUES (:nome, :email, :senha)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha',password_hash( $senha, PASSWORD_bCRYPT));
    $stmt->bindParam(':tipo', $tipo_orcamento);
    $stmt->bindParam(':status', $status_orcamento);
    if($stmt->execute()){
        return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
function atualizarOrcamento($id, $nome, $email, $senha = null, $tipo = null, $status = null){
        $sql = "UPDATE tbl_orcamento SET nome_orcamento = :nome, email_orcamento = :email";
        if($senha){
            $sql .= ", senha_orcamento = :senha";
        }
        if($tipo){
            $sql .= ", tipo_orcamento = :tipo";
        }
        if($status){
            $sql .= ", status_orcamento = :status";
        }
        $sql .= ", atualizado_em = NOW() WHERE id_orcamento = :id";
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
    function deletarOrcamento($id){
        $sql = "UPDATE tbl_orcamento SET excluido_em = NOW() WHERE id_orcamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
function buscarOrcamentosPorID($db,$id){
    $sql = 'SELECT nome_orcamento, email_orcamento FROM tbl_orcamento WHERE id_orcamento = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
   
}

//19/09
 
//metodo de inativar o orcamento delete
function inativarOrcamento($id){
    $dataatual = date('Y-m-d H:i:s');
    $sql = "UPDATE tbl_orcamento SET excluido_em = :atual WHERE id_orcamento = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if ($stmt->execute()){
    return true;
    } else {
        return false;
    };
}

//metodo de ativar o orcamento excluido read
function ativarOrcamento($id){
    $sql = "UPDATE tbl_orcamento SET excluido_em = :atual WHERE id_orcamento = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if ($stmt->execute()){
        return true;
    } else {
        return false;
    };
}
// metodo de buscar todos os orcamentos
function buscarTodosOrcamentos(){
    $sql = "SELECT * FROM tbl_orcamento WHERE excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// orcamentos inativos
function buscarTodosOrcamentosInativos(){
    $sql = "SELECT * FROM tbl_orcamento WHERE excluido_em IS NOT NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}