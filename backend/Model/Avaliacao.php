<?php

namespace App\Misu\Model;

use PDO;


$usuario = new Usuario($db);
$avaliacao = new Avaliacao($db);

/* Executa uma instrução preparada passando um array de valores */
class Avaliacao{
    private $id_avaliacao;
    private $id_cliente;
    private $id_servico;
    private $descricao_avaliacao;
    private $nota_avaliacao;
    private $status_avaliacao;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    //construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }

    // --------------- MÉTODOS DE BUSCA DE DADOS ---------------

 // metodo de buscar todos os Avaliacaos
    function buscarAvaliacaos($db){
        $sql = "SELECT * FROM tbl_avaliacao";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($db);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os avaliacaos por usuario
    function buscarAvaliacaoPorUsuario($usuario){
        $sql = "SELECT * FROM tbl_avaliacao where id_cliente = :usuario and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario', $usuario); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os avaliacaos por Servico
    function buscarAvaliacaoPorServico($servico){
        $sql = "SELECT * FROM tbl_avaliacao where id_servico = :servico and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':servico', $servico); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os avaliacaos por data
    function buscarAvaliacaoPorData($data_solicitada){
        $sql = "SELECT * FROM tbl_avaliacao where data_solicitada = :data_solicitada and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':data_solicitada', $data_solicitada); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
     // metodo de buscar todos os avaliacaos pelo Total
     function buscarAvaliacaoPorTotal($total_avaliacao){
        $sql = "SELECT * FROM tbl_avaliacao where total_avaliacao = :total_avaliacao and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':total_avaliacao', $total_avaliacao); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // metodo de buscar todos os avaliacaos por status
     function buscarAvaliacaoPorStatus($status_avaliacao){
        $sql = "SELECT * FROM tbl_avaliacao where status_avaliacao = :status_avaliacao and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status_avaliacao', $status_avaliacao); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // avaliacaos inativos
    function buscarTodosAvaliacaosInativos(){
        $sql = "SELECT * FROM tbl_avaliacao where excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de buscar avaliacao por ID
    function buscarAvaliacaoPorID($db,$id){
        $sql = 'SELECT id_avaliacao FROM tbl_avaliacao WHERE id_avaliacao = :id';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }



// --------------- MÉTODOS DE ALTERAÇÃO DE DADOS ---------------

 

// metodo de registrar avaliacao

function registrarAvaliacao($db, $data_solicitada, $total_avaliacao, $status_avaliacao){
    $sql = 'INSERT INTO tbl_avaliacao (data_solicitada, total_avaliacao, status_avaliacao)
    VALUES (:data_solicitada, :total_avaliacao, :status_avaliacao)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':data_solicitada', $data_solicitada);
    $stmt->bindParam(':total_avaliacao', $total_avaliacao);
    $stmt->bindParam(':status_avaliacao', $status_avaliacao);
    if($stmt->execute()){
        return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
     
  // metodo de atualizar o usuario // update
    function atualizarAvaliacao($id, $data_solicitada, $status_avaliacao, $total_avaliacao){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_avaliacao SET data_solicitada = :data_solicitada,
         email_avaliacao = :email, 
         total_avaliacao = :total_avaliacao, 
         status_avaliacao = :status,
         atualizado_em = :atual
         WHERE id_avaliacao = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':data_solicitada', $data_solicitada);
        $stmt->bindParam(':total_avaliacao', $total_avaliacao);
        $stmt->bindParam(':status_avaliacao', $status_avaliacao);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

//metodo de inativar o avaliacao // delete
function inativarAvaliacao($id){
    $dataatual = date('Y-m-d H:i:s');
    $sql = "UPDATE tbl_avaliacao SET excluido_em = :atual WHERE id_avaliacao = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if ($stmt->execute()){
    return true;
    } else {
        return false;
    };
}

    //metodo de ativar o avaliacao excluido 
function ativarAvaliacaoExcluido($id){
    $sql = "UPDATE tbl_avaliacao SET excluido_em = :atual WHERE id_avaliacao = :id";
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