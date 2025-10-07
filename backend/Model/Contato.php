<?php
namespace App\Misu\Model;

use PDO;


class Contato{
    private $id_contato;
    private $nome_contato;
    private $telefone_contato;
    private $email_contato;
    private $mensagem_contato;
    private $status_contato;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
 // contrutor inicializa a classe e ou atributos
  public function __construct($db){
        $this->db = $db;
    }

// --------------- MÉTODOS DE BUSCA DE DADOS ---------------

 // metodo de buscar todos os Contatos
    function buscarContatos($db){
        $sql = "SELECT * FROM tbl_contato";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($db);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os Contatos por usuario
    function buscarContatoPorUsuario($usuario){
        $sql = "SELECT * FROM tbl_contato where id_cliente = :usuario and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario', $usuario); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os Contatos por Servico
    function buscarContatoPorServico($servico){
        $sql = "SELECT * FROM tbl_contato where id_servico = :servico and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':servico', $servico); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os Contatos por data
    function buscarContatoPorData($data_solicitada){
        $sql = "SELECT * FROM tbl_contato where data_solicitada = :data_solicitada and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':data_solicitada', $data_solicitada); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
     // metodo de buscar todos os Contatos pelo Total
     function buscarContatoPorTotal($total_Contato){
        $sql = "SELECT * FROM tbl_contato where total_contato = :total_contato and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':total_contato', $total_Contato); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // metodo de buscar todos os Contatos por status
     function buscarContatoPorStatus($status_Contato){
        $sql = "SELECT * FROM tbl_contato where status_contato = :status_contato and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status_contato', $status_Contato); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Contatos inativos
    function buscarTodosContatosInativos(){
        $sql = "SELECT * FROM tbl_contato where excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de buscar Contato por ID
    function buscarContatoPorID($db,$id){
        $sql = 'SELECT id_contato FROM tbl_contato WHERE id_contato = :id';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }



// --------------- MÉTODOS DE ALTERAÇÃO DE DADOS ---------------

 

// metodo de registrar Contato

function registrarContato($db, $data_solicitada, $total_contato, $status_contato){
    $sql = 'INSERT INTO tbl_contato (data_solicitada, total_contato, status_Contato)
    VALUES (:data_solicitada, :total_Contato, :status_Contato)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':data_solicitada', $data_solicitada);
    $stmt->bindParam(':total_Contato', $total_contato);
    $stmt->bindParam(':status_Contato', $status_contato);
    if($stmt->execute()){
        return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
     
  // metodo de atualizar o usuario // update
    function atualizarContato($id, $data_solicitada, $status_Contato, $total_Contato){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_contato SET data_solicitada = :data_solicitada,
         email_Contato = :email, 
         total_Contato = :total_Contato, 
         status_Contato = :status,
         atualizado_em = :atual
         WHERE id_Contato = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':data_solicitada', $data_solicitada);
        $stmt->bindParam(':total_Contato', $total_Contato);
        $stmt->bindParam(':status_Contato', $status_Contato);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

//metodo de inativar o Contato // delete
function inativarContato($id){
    $dataatual = date('Y-m-d H:i:s');
    $sql = "UPDATE tbl_contato SET excluido_em = :atual WHERE id_contato = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if ($stmt->execute()){
    return true;
    } else {
        return false;
    };
}

    //metodo de ativar o Contato excluido 
function ativarContatoExcluido($id){
    $sql = "UPDATE tbl_contato SET excluido_em = :atual WHERE id_contato = :id";
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