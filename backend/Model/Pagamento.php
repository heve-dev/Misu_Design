<?php

namespace App\Misu\Model;

use PDO;


/* Executa uma instrução preparada passando um array de valores */
class Pagamento{
    private $id_pagamento;
    private $id_cliente;
    private $total_devedor;
    private $status_pagamento;
    private $data_pagamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;

 // contrutor inicializa a classe e ou atributos
  public function __construct($db){
        $this->db = $db;
    }
// --------------- MÉTODOS DE BUSCA DE DADOS ---------------

 // metodo de buscar todos os pagamentos
    function buscarPagamentos($db){
        $sql = "SELECT * FROM tbl_pagamento";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($db);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os pagamentos por usuario
    function buscarPagamentoPorUsuario($usuario){
        $sql = "SELECT * FROM tbl_pagamento where id_cliente = :usuario and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario', $usuario); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os pagamentos por Servico
    function buscarPagamentoPorServico($servico){
        $sql = "SELECT * FROM tbl_pagamento where id_servico = :servico and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':servico', $servico); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os pagamentos por data
    function buscarPagamentoPorData($data_solicitada){
        $sql = "SELECT * FROM tbl_pagamento where data_solicitada = :data_solicitada and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':data_solicitada', $data_solicitada); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
     // metodo de buscar todos os pagamentos pelo Total
     function buscarPagamentoPorTotal($total_pagamento){
        $sql = "SELECT * FROM tbl_pagamento where total_pagamento = :total_pagamento and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':total_pagamento', $total_pagamento); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // metodo de buscar todos os pagamentos por status
     function buscarPagamentoPorStatus($status_pagamento){
        $sql = "SELECT * FROM tbl_pagamento where status_pagamento = :status_pagamento and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status_pagamento', $status_pagamento); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // pagamentos inativos
    function buscarTodosPagamentosPendentes(){
        $sql = "SELECT * FROM tbl_pagamento where excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de buscar pagamento por ID
    function buscarPagamentoPorID($db,$id){
        $sql = 'SELECT id_pagamento FROM tbl_pagamento WHERE id_pagamento = :id';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }



// --------------- MÉTODOS DE ALTERAÇÃO DE DADOS ---------------

 

// metodo de registrar pagamento

function registrarPagamento($db, $data_solicitada, $total_pagamento, $status_pagamento){
    $sql = 'INSERT INTO tbl_pagamento (data_solicitada, total_pagamento, status_pagamento)
    VALUES (:data_solicitada, :total_pagamento, :status_pagamento)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':data_solicitada', $data_solicitada);
    $stmt->bindParam(':total_pagamento', $total_pagamento);
    $stmt->bindParam(':status_pagamento', $status_pagamento);
    if($stmt->execute()){
        return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
     
  // metodo de atualizar o usuario // update
    function atualizarPagamento($id, $data_solicitada, $status_pagamento, $total_pagamento){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_pagamento SET data_solicitada = :data_solicitada,
         email_pagamento = :email, 
         total_pagamento = :total_pagamento, 
         status_pagamento = :status,
         atualizado_em = :atual
         WHERE id_pagamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':data_solicitada', $data_solicitada);
        $stmt->bindParam(':total_pagamento', $total_pagamento);
        $stmt->bindParam(':status_pagamento', $status_pagamento);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

//metodo de inativar o pagamento // delete
function quitarPagamento($id){
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

    //metodo de ativar o pagamento excluido 
function atualizarPagamentoQuitado($id){
    $sql = "UPDATE tbl_pagamento SET excluido_em = :atual WHERE id_pagamento = :id";
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