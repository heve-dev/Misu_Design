<?php

require_once __DIR__.'/../Config/Database.php';
require_once __DIR__.'/../Model/usuario.php';
require_once __DIR__.'/../Model/Config.php';
$usuario = new Usuario($db);
$agendamento = new Agendamento($db);

/* Executa uma instrução preparada passando um array de valores */
class Agendamento{
    private $id_agendamento;
    private $nome_agendamento;
    private $email_agendamento;
    private $tipo_agendamento;
    private $senha_agendamento;
    private $status_agendamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    //construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }
 
/* Executa uma instrução preparada passando um array de valores */
function buscarAgendamento($db){
   
    $sql = 'SELECT nome_agendamento, email_agendamento FROM tbl_agendamento';
    $statment = $db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $statment->execute();
    return $resultado = $statment->fetchAll();
 
}
function buscarAgendamentoPorEmail($db,$email){
    $sql = 'SELECT nome_agendamento, email_agendamento FROM tbl_agendamento WHERE email_agendamento = :email';
    $statment = $db->prepare($sql);
    $statment->bindParam(':email', $email);
    $statment->execute();
    return $resultado = $statment->fetchAll();
   
}
function registrarAgendamento($db, $nome, $email, $senha){
    $sql = 'INSERT INTO tbl_agendamento (nome_agendamento, email_agendamento, senha_agendamento)
    VALUES (:nome, :email, :senha)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha',password_hash( $senha, PASSWORD_bCRYPT));
    $stmt->bindParam(':tipo', $tipo_agendamento);
    $stmt->bindParam(':status', $status_agendamento);
    if($stmt->execute()){
        return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
function atualizarAgendamento($id, $nome, $email, $senha = null, $tipo = null, $status = null){
        $sql = "UPDATE tbl_agendamento SET nome_agendamento = :nome, email_agendamento = :email";
        if($senha){
            $sql .= ", senha_agendamento = :senha";
        }
        if($tipo){
            $sql .= ", tipo_agendamento = :tipo";
        }
        if($status){
            $sql .= ", status_agendamento = :status";
        }
        $sql .= ", atualizado_em = NOW() WHERE id_agendamento = :id";
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
    function deletarAgendamento($id){
        $sql = "UPDATE tbl_agendamento SET excluido_em = NOW() WHERE id_agendamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
function buscarAgendamentoPorID($db,$id){
    $sql = 'SELECT nome_agendamento, email_agendamento FROM tbl_agendamento WHERE id_agendamento = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
   
}

//19/09
 
//metodo de inativar o agendamento delete
function inativarAgendamento($id){
    $dataatual = date('Y-m-d H:i:s');
    $sql = "UPDATE tbl_agendamento SET excluido_em = :atual WHERE id_agendamento = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if ($stmt->execute()){
    return true;
    } else {
        return false;
    };
}

//metodo de ativar o agendamento excluido read
function ativarAgendamento($id){
    $sql = "UPDATE tbl_agendamento SET excluido_em = :atual WHERE id_agendamento = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if ($stmt->execute()){
        return true;
    } else {
        return false;
    };
}
// metodo de buscar todos os agendamentos
function buscarTodosAgendamento(){
    $sql = "SELECT * FROM tbl_agendamento WHERE excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// agendamentos inativos
function buscarTodosAgendamentoInativos(){
    $sql = "SELECT * FROM tbl_agendamento WHERE excluido_em IS NOT NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//metodo de buscar agendamento por email read
function buscarAgendamentoPorEmail($email){
    $sql = "SELECT * FROM tbl_agendamento WHERE email_agendamento = :email AND excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
// emails inativos read
function buscarAgendamentoPorEmailInativo($email){
    $sql = "SELECT * FROM tbl_agendamento WHERE email_agendamento = :email AND excluido_em IS NOT NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
