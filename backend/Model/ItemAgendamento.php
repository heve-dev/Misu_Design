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
 // metodo de buscar todos os Itemagendamento
    function buscarItemAgendamento(){
        $sql = "SELECT * FROM tbl_item_agendamento";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
function buscarItemAgendamentoInativos(){
        $sql = "SELECT * FROM tbl_item_agendamento where excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarItemAgendamentoPorId($db,$id){
    $sql = 'SELECT valor_servico, quantidade_solicitada, status_item_agendamento FROM tbl_item_agendamento WHERE id_item_agendamento = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
   
}

// metodo de inserir usuario create
    function inserirItemAgendamento($valor, $quantidade, $descricao, $total, $status){
       
        $sql = "INSERT INTO tbl_item_agendamento (valor_servico, quantidade_solicitada, 
        descricao_item_agendamento, total_item_agendamento, status_item_agendamento) 
                VALUES (:valor, :quantidade, :descricao, :total, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':total',  $total);
        $stmt->bindParam(':status', $status);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }
  // metodo de atualizar o usuario // update
    function atualizarItemAgendamento($id, $valor, $quantidade, $descricao, $total, $status){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl__item_agendamento SET 
         valor_servico = :valor,
         quantidade_solicitada = :quantidade, 
         descricao__item_agendamento = :descricao, 
         total__item_agendamento = :total,
         status__item_agendamento = :status,
         atualizado_em = :atual
         WHERE id__item_agendamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':total',  $total);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    // metodo de inativar o Itemagendamento// delete
    function excluirItemAgendamento($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_item_agendamento SET excluido_em = :atual WHERE 
        id_item_agendamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
// metodo de ativar o _item_Agendamento excluido
    function ativarItemAgendamento($id){
        $dataatual = NULL;
        $sql = "UPDATE tbl_item_agendamento SET
         excluido_em = :atual
         WHERE id_item_agendamento = :id";
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