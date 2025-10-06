<?php

namespace App\Misu\Model;

use PDO;

class ItemAgendamento{
    private $id_item_agendamento;
    private $id_agendamento;
    private $id_servico;
    private $id_cliente;
    private $valor_servico;
    private $quantidade_solicitada;
    private $descricao_item_agendamento;
    private $total_item;
    private $status_item_agendamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
 // contrutor inicializa a classe e ou atributos
  public function __construct($db){
        $this->db = $db;
    }
// --------------- MÉTODOS DE BUSCA DE DADOS ---------------

 // metodo de buscar todos os Agendamentos
    function buscarAgendamentos($db){
        $sql = "SELECT * FROM tbl_agendamento";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($db);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os agendamentos por usuario
    function buscarAgendamentoPorUsuario($usuario){
        $sql = "SELECT * FROM tbl_agendamento where id_cliente = :usuario and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario', $usuario); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os agendamentos por Servico
    function buscarAgendamentoPorServico($servico){
        $sql = "SELECT * FROM tbl_agendamento where id_servico = :servico and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':servico', $servico); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os agendamentos por data
    function buscarAgendamentoPorData($data_solicitada){
        $sql = "SELECT * FROM tbl_agendamento where data_solicitada = :data_solicitada and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':data_solicitada', $data_solicitada); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
     // metodo de buscar todos os agendamentos pelo Total
     function buscarAgendamentoPorTotal($total_agendamento){
        $sql = "SELECT * FROM tbl_agendamento where total_agendamento = :total_agendamento and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':total_agendamento', $total_agendamento); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // metodo de buscar todos os agendamentos por status
     function buscarAgendamentoPorStatus($status_agendamento){
        $sql = "SELECT * FROM tbl_agendamento where status_agendamento = :status_agendamento and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status_agendamento', $status_agendamento); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // agendamentos inativos
    function buscarTodosAgendamentosInativos(){
        $sql = "SELECT * FROM tbl_agendamento where excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de buscar agendamento por ID
    function buscarAgendamentoPorID($db,$id){
        $sql = 'SELECT id_agendamento FROM tbl_agendamento WHERE id_agendamento = :id';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }



// --------------- MÉTODOS DE ALTERAÇÃO DE DADOS ---------------

 

// metodo de registrar agendamento

function registrarAgendamento($db, $data_solicitada, $total_agendamento, $status_agendamento){
    $sql = 'INSERT INTO tbl_agendamento (data_solicitada, total_agendamento, status_agendamento)
    VALUES (:data_solicitada, :total_agendamento, :status_agendamento)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':data_solicitada', $data_solicitada);
    $stmt->bindParam(':total_agendamento', $total_agendamento);
    $stmt->bindParam(':status_agendamento', $status_agendamento);
    if($stmt->execute()){
        return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
     
  // metodo de atualizar o usuario // update
    function atualizarAgendamento($id, $data_solicitada, $status_agendamento, $total_agendamento){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_agendamento SET data_solicitada = :data_solicitada,
         email_agendamento = :email, 
         total_agendamento = :total_agendamento, 
         status_agendamento = :status,
         atualizado_em = :atual
         WHERE id_agendamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':data_solicitada', $data_solicitada);
        $stmt->bindParam(':total_agendamento', $total_agendamento);
        $stmt->bindParam(':status_agendamento', $status_agendamento);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

//metodo de inativar o agendamento // delete
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

    //metodo de ativar o agendamento excluido 
function ativarAgendamentoExcluido($id){
    $sql = "UPDATE tbl_agendamento SET excluido_em = :atual WHERE id_agendamento = :id";
     $dataatual = date('Y-m-d H:i:s');
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if ($stmt->execute()){
        return true;
    } else {
        return false;
    };
}
}