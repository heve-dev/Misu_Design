<?php

namespace App\Misu\Model;

use PDO;

/* Executa uma instrução preparada passando um array de valores */
class Orcamento{
    private $id_orcamento;
    private $id_cliente;
    private $id_categoria;
    private $id_pagamento;
    private $descricao_orcamento;
    private $status_orcamento;
    private $data_orcamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;

 // contrutor inicializa a classe e ou atributos
  public function __construct($db){
        $this->db = $db;
    }

// --------------- MÉTODOS DE BUSCA DE DADOS ---------------

 // metodo de buscar todos os orcamentos
    function buscarOrcamentos($db){
        $sql = "SELECT * FROM tbl_orcamento";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($db);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os orcamentos por usuario
    function buscarOrcamentoPorUsuario($usuario){
        $sql = "SELECT * FROM tbl_orcamento where id_cliente = :usuario and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario', $usuario); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os orcamentos por Servico
    function buscarOrcamentoPorServico($servico){
        $sql = "SELECT * FROM tbl_orcamento where id_servico = :servico and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':servico', $servico); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os orcamentos por data
    function buscarOrcamentoPorData($data_solicitada){
        $sql = "SELECT * FROM tbl_orcamento where data_solicitada = :data_solicitada and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':data_solicitada', $data_solicitada); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
     // metodo de buscar todos os orcamentos pelo Total
     function buscarOrcamentoPorTotal($total_orcamento){
        $sql = "SELECT * FROM tbl_orcamento where total_orcamento = :total_orcamento and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':total_orcamento', $total_orcamento); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // metodo de buscar todos os orcamentos por status
     function buscarOrcamentoPorStatus($status_orcamento){
        $sql = "SELECT * FROM tbl_orcamento where status_orcamento = :status_orcamento and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status_orcamento', $status_orcamento); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // orcamentos inativos
    function buscarTodosOrcamentosInativos(){
        $sql = "SELECT * FROM tbl_orcamento where excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de buscar orcamento por ID
    function buscarOrcamentoPorID($db,$id){
        $sql = 'SELECT id_orcamento FROM tbl_orcamento WHERE id_orcamento = :id';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }



// --------------- MÉTODOS DE ALTERAÇÃO DE DADOS ---------------

 

// metodo de registrar orcamento

function registrarOrcamento($db, $data_solicitada, $total_orcamento, $status_orcamento){
    $sql = 'INSERT INTO tbl_orcamento (data_solicitada, total_orcamento, status_orcamento)
    VALUES (:data_solicitada, :total_orcamento, :status_orcamento)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':data_solicitada', $data_solicitada);
    $stmt->bindParam(':total_orcamento', $total_orcamento);
    $stmt->bindParam(':status_orcamento', $status_orcamento);
    if($stmt->execute()){
        return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
     
  // metodo de atualizar o usuario // update
    function atualizarOrcamento($id, $data_solicitada, $status_orcamento, $total_orcamento){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_orcamento SET data_solicitada = :data_solicitada,
         email_orcamento = :email, 
         total_orcamento = :total_orcamento, 
         status_orcamento = :status,
         atualizado_em = :atual
         WHERE id_orcamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':data_solicitada', $data_solicitada);
        $stmt->bindParam(':total_orcamento', $total_orcamento);
        $stmt->bindParam(':status_orcamento', $status_orcamento);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

//metodo de inativar o orcamento // delete
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

    //metodo de ativar o orcamento excluido 
function ativarOrcamentoExcluido($id){
    $sql = "UPDATE tbl_orcamento SET excluido_em = :atual WHERE id_orcamento = :id";
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