<?php

namespace App\Misu\Model;

use PDO;

class ItemAgendamento{
    private $id_item_item_agendamento;
    private $id_item_agendamento;
    private $id_servico;
    private $id_cliente;
    private $valor_servico;
    private $quantidade_solicitada;
    private $descricao_item_item_agendamento;
    private $total_item;
    private $status_item_item_agendamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
 // contrutor inicializa a classe e ou atributos
  public function __construct($db){
        $this->db = $db;
    }
// --------------- MÉTODOS DE BUSCA DE DADOS ---------------

 // metodo de buscar todos os item_agendamentos
    function buscarItemAgendamentos($db){
        $sql = "SELECT * FROM tbl_item_agendamento";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($db);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os item_agendamentos por usuario
    function buscarItemAgendamentoPorUsuario($usuario){
        $sql = "SELECT * FROM tbl_item_agendamento where id_cliente = :usuario and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario', $usuario); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os item_agendamentos por Servico
    function buscarItemAgendamentoPorServico($servico){
        $sql = "SELECT * FROM tbl_item_agendamento where id_servico = :servico and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':servico', $servico); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os item_agendamentos por data
    function buscaritem_agendamentoPorData($data_solicitada){
        $sql = "SELECT * FROM tbl_item_agendamento where data_solicitada = :data_solicitada and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':data_solicitada', $data_solicitada); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
     // metodo de buscar todos os item_agendamentos pelo Total
     function buscarItemAgendamentoPorTotal($total_item_agendamento){
        $sql = "SELECT * FROM tbl_item_agendamento where total_item_agendamento = :total_item_agendamento and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':total_item_agendamento', $total_item_agendamento); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // metodo de buscar todos os item_agendamentos por status
     function buscarItemAgendamentoPorStatus($status_item_agendamento){
        $sql = "SELECT * FROM tbl_item_agendamento where status_item_agendamento = :status_item_agendamento and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status_item_agendamento', $status_item_agendamento); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // item_agendamentos inativos
    function buscarTodosItemAgendamentosInativos(){
        $sql = "SELECT * FROM tbl_item_agendamento where excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de buscar item_agendamento por ID
    function buscarItemAgendamentoPorID($db,$id){
        $sql = 'SELECT id_item_agendamento FROM tbl_item_agendamento WHERE id_item_agendamento = :id';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }



// --------------- MÉTODOS DE ALTERAÇÃO DE DADOS ---------------

 

// metodo de registrar item_agendamento

function registrarItemAgendamento($db, $data_solicitada, $total_item_agendamento, $status_item_agendamento){
    $sql = 'INSERT INTO tbl_item_agendamento (data_solicitada, total_item_agendamento, status_item_agendamento)
    VALUES (:data_solicitada, :total_item_agendamento, :status_item_agendamento)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':data_solicitada', $data_solicitada);
    $stmt->bindParam(':total_item_agendamento', $total_item_agendamento);
    $stmt->bindParam(':status_item_agendamento', $status_item_agendamento);
    if($stmt->execute()){
        return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
     
  // metodo de atualizar o usuario // update
    function atualizarItemAgendamento($id, $data_solicitada, $status_item_agendamento, $total_item_agendamento){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_item_agendamento SET data_solicitada = :data_solicitada,
         email_item_agendamento = :email, 
         total_item_agendamento = :total_item_agendamento, 
         status_item_agendamento = :status,
         atualizado_em = :atual
         WHERE id_item_agendamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':data_solicitada', $data_solicitada);
        $stmt->bindParam(':total_item_agendamento', $total_item_agendamento);
        $stmt->bindParam(':status_item_agendamento', $status_item_agendamento);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

//metodo de inativar o item_agendamento // delete
function inativarItemAgendamento($id){
    $dataatual = date('Y-m-d H:i:s');
    $sql = "UPDATE tbl_item_agendamento SET excluido_em = :atual WHERE id_item_agendamento = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if ($stmt->execute()){
    return true;
    } else {
        return false;
    };
}

    //metodo de ativar o item_agendamento excluido 
function ativarItemAgendamentoExcluido($id){
    $sql = "UPDATE tbl_item_agendamento SET excluido_em = :atual WHERE id_item_agendamento = :id";
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