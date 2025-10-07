<?php

namespace App\Misu\Model;

use PDO;

/* Executa uma instrução preparada passando um array de valores */
class Categoria{
    private $id_categoria;
    private $nome_categoria;
    private $descricao_categoria;
    private $foto_categoria;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    //construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }

// --------------- MÉTODOS DE BUSCA DE DADOS ---------------

 // metodo de buscar todos os categorias
    function buscarCategorias($db){
        $sql = "SELECT * FROM tbl_categoria";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($db);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os categorias por usuario
    function buscarCategoriaPorUsuario($usuario){
        $sql = "SELECT * FROM tbl_categoria where id_cliente = :usuario and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario', $usuario); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os categorias por Servico
    function buscarCategoriaPorServico($servico){
        $sql = "SELECT * FROM tbl_categoria where id_servico = :servico and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':servico', $servico); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os categorias por data
    function buscarCategoriaPorData($data_solicitada){
        $sql = "SELECT * FROM tbl_categoria where data_solicitada = :data_solicitada and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':data_solicitada', $data_solicitada); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
     // metodo de buscar todos os categorias pelo Total
     function buscarCategoriaPorTotal($total_categoria){
        $sql = "SELECT * FROM tbl_categoria where total_categoria = :total_categoria and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':total_categoria', $total_categoria); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // metodo de buscar todos os categorias por status
     function buscarCategoriaPorStatus($status_categoria){
        $sql = "SELECT * FROM tbl_categoria where status_categoria = :status_categoria and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status_categoria', $status_categoria); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // categorias inativos
    function buscarTodosCategoriasInativos(){
        $sql = "SELECT * FROM tbl_categoria where excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de buscar categoria por ID
    function buscarCategoriaPorID($db,$id){
        $sql = 'SELECT id_categoria FROM tbl_categoria WHERE id_categoria = :id';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }



// --------------- MÉTODOS DE ALTERAÇÃO DE DADOS ---------------

 

// metodo de registrar categoria

function registrarCategoria($db, $data_solicitada, $total_categoria, $status_categoria){
    $sql = 'INSERT INTO tbl_categoria (data_solicitada, total_categoria, status_categoria)
    VALUES (:data_solicitada, :total_categoria, :status_categoria)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':data_solicitada', $data_solicitada);
    $stmt->bindParam(':total_categoria', $total_categoria);
    $stmt->bindParam(':status_categoria', $status_categoria);
    if($stmt->execute()){
        return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
     
  // metodo de atualizar o usuario // update
    function atualizarCategoria($id, $data_solicitada, $status_categoria, $total_categoria){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_categoria SET data_solicitada = :data_solicitada,
         email_categoria = :email, 
         total_categoria = :total_categoria, 
         status_categoria = :status,
         atualizado_em = :atual
         WHERE id_categoria = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':data_solicitada', $data_solicitada);
        $stmt->bindParam(':total_categoria', $total_categoria);
        $stmt->bindParam(':status_categoria', $status_categoria);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

//metodo de inativar o categoria // delete
function inativarCategoria($id){
    $dataatual = date('Y-m-d H:i:s');
    $sql = "UPDATE tbl_categoria SET excluido_em = :atual WHERE id_categoria = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if ($stmt->execute()){
    return true;
    } else {
        return false;
    };
}

    //metodo de ativar o categoria excluido 
function ativarCategoriaExcluido($id){
    $sql = "UPDATE tbl_categoria SET excluido_em = :atual WHERE id_categoria = :id";
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