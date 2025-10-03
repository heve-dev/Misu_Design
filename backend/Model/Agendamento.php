<?php
namespace App\Misu\Model;

use PDO;

$usuario = new Usuario($db);
$agendamento = new Agendamento($db);

/* Executa uma instrução preparada passando um array de valores */
class Agendamento{
    private $id_agendamento;
    private $id_cliente;
    private $id_servico;
    private $data_solicitada;
    private $total_agendamento;
    private $status_agendamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    //construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }

    //  $id_agendamento;
    //  $id_cliente;
    //  $id_servico;
    //  $data_solicitada;
    //  $total_agendamento;
    //  $status_agendamento;
    //  $criado_em;
    //  $atualizado_em;
    //  $excluido_em;
 


 // metodo de buscar todos os Agendamentos
    function buscarAgendamento($db){
        $sql = "SELECT * FROM tbl_agendamento";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function buscarAgendamentosInativos(){
        $sql = "SELECT * FROM tbl_usuario where excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarAgendamentoPorID($db,$id){
        $sql = 'SELECT nome_agendamento, email_agendamento FROM tbl_agendamento WHERE id_agendamento = :id';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }


    //-----

    // metodo de buscar todos usuario por email
    function buscarUsuariosPorEMail($email){
        $sql = "SELECT * FROM tbl_usuario where email_usuario = :email and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function buscarUsuariosPorEMailInativo($email){
        $sql = "SELECT * FROM tbl_usuario where email_usuario = :email and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de inserir usuario create
    function inserirUsuario(
        $nome, 
        $email, 
        $senha, 
        $tipo, 
        $status){
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO tbl_usuario (nome_usuario, email_usuario, 
        senha_usuario, tipo_usuario, status_usuario) 
                VALUES (:nome, :email, :senha, :tipo, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':status', $status);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }
  // metodo de atualizar o usuario // update
    function atualizarUsuario($id, $nome, $email, $senha, $tipo, $status){
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_usuario SET nome_usuario = :nome,
         email_usuario = :email, 
         senha_usuario = :senha, 
         tipo_usuario = :tipo,
         status_usuario = :status,
         atualizado_em = :atual
         WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    // metodo de inativar o usuario // delete
    function excluirUsuario($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_usuario SET excluido_em = :atual WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
// metodo de ativar o usuario excluido
    function ativarUsuario($id){
        $dataatual = NULL;
        $sql = "UPDATE tbl_usuario SET
         excluido_em = :atual
         WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}





//----



function registrarAgendamento($db, $data_solicitada, $total_agendamento, $status_agendamento){
    $sql = 'INSERT INTO tbl_agendamento (data_solicitada, total_agendamento, status_agendamento)
    VALUES (:data, :total, :status)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':data', $data_solicitada);
    $stmt->bindParam(':total', $total_agendamento);
    $stmt->bindParam(':status', $status_agendamento);
    if($stmt->execute()){
        return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
function atualizarAgendamento($id,$db, $data_solicitada, $total_agendamento, $status_agendamento = null){
        $sql = "UPDATE tbl_agendamento SET nome_agendamento = :nome, total_agendamento = :total";
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


