<?php

namespace App\Misu\Model;

use PDO;

$usuario = new Usuario($db);
$servico = new Servico($db);

/* Executa uma instrução preparada passando um array de valores */
class Servico{
    private $id_servico;
    private $id_categoria;
    private $nome_servico;
    private $descricao_servico;
    private $valor_servico;
    private $foto_servico;
    private $status_servico;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private  $db;

 // contrutor inicializa a classe e ou atributos
  public function __construct($db){
        $this->db = $db;
    }

// --------------- MÉTODOS DE BUSCA DE DADOS ---------------

 // metodo de buscar todos os servicos
    function buscarTodosServicos(){
        $sql = "SELECT * FROM tbl_servico";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de buscar todos os servicos
    function buscarServicos(){
        $sql = "SELECT * FROM tbl_servico";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

// metodo de buscar todos os servicos por categoria
    function buscarServicosPorCategoria($categoria){
        $sql = "SELECT * FROM tbl_servico where id_categoria = :categoria and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario', $categoria); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

// metodo de buscar todos os servicos inativos   
function buscarServicosInativos(){
        $sql = "SELECT * FROM tbl_servico where excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os servicos por ID
    function buscarServicosPorId($db,$id){
    $sql = 'SELECT nome_usuario, email_usuario FROM tbl_servico WHERE id_usuario = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
   
}
//     $id_servico;
//     $id_categoria;
//     $nome_servico;
//     $descricao_servico;
//     $valor_servico;
//     $foto_servico;
//     $status_servico;
//     $criado_em;
//     $atualizado_em;
//     $excluido_em;
// --------------- MÉTODOS DE ALTERAÇÃO DE DADOS ---------------

// metodo de registrar usuario // create
    function registrarServicos($nome, $email, $senha, $tipo, $status){
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO tbl_servico (nome_usuario, email_usuario, 
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
    function atualizarServicos($id, $nome, $email, $senha, $tipo, $status){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_servico SET nome_usuario = :nome,
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
    // metodo de inativar o servico // delete
    function inativarServicos($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_servico SET excluido_em = :atual WHERE id_servico = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
// metodo de ativar o servico excluido
    function ativarServicosExcluido($id){
        $dataatual = NULL;
        $sql = "UPDATE tbl_servico SET
         excluido_em = :atual
         WHERE id_servico = :id";
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