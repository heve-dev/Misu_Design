<?php

namespace App\Misu\Model;

use PDO;

class ItemOrcamento{
    private $id_item_orcamento;
    private $id_orcamento;
    private $id_servico;
    private $id_cliente;
    private $valor_servico;
    private $quantidade_solicitada;
    private $descricao_item_orcamento;
    private $total_item_orcamento;
    private $status_item_orcamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;

 // contrutor inicializa a classe e ou atributos
  public function __construct($db){
        $this->db = $db;
    }
 // metodo de buscar todos os ItemOrcamento
    function buscarItemOrcamento(){
        $sql = "SELECT * FROM tbl_item_orcamento";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
function buscarItemOrcamentoInativos(){
        $sql = "SELECT * FROM tbl_item_orcamento where excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarItemOrcamentoPorId($db,$id){
    $sql = 'SELECT valor_servico, quantidade_solicitada, status_item_orcamento FROM tbl_item_orcamento WHERE id_item_orcamento = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
   
}

// metodo de inserir usuario create
    function inserirItemOrcamento($valor, $quantidade, $descricao, $total, $status){
       
        $sql = "INSERT INTO tbl_item_orcamento (valor_servico, quantidade_solicitada, 
        descricao_item_orcamento, total_item_orcamento, status_item_orcamento) 
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
    function atualizarItemOrcamento($id, $valor, $quantidade, $descricao, $total, $status){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl__item_orcamento SET 
         valor_servico = :valor,
         quantidade_solicitada = :quantidade, 
         descricao__item_orcamento = :descricao, 
         total__item_orcamento = :total,
         status__item_orcamento = :status,
         atualizado_em = :atual
         WHERE id__item_orcamento = :id";
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
    // metodo de inativar o ItemOrcamento// delete
    function excluirItemOrcamento($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_item_orcamento SET excluido_em = :atual WHERE 
        id_item_orcamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
// metodo de ativar o _item_orcamento excluido
    function ativarItemOrcamento($id){
        $dataatual = NULL;
        $sql = "UPDATE tbl_item_orcamento SET
         excluido_em = :atual
         WHERE id_item_orcamento = :id";
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