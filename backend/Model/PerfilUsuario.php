<?php
namespace App\Misu\Model;

use PDO;



/* Executa uma instrução preparada passando um array de valores */
class Usuario{
    private $id_perfil_usuario;
    private $id_usuario;
    private $descricao_perfil_usuario;
    private $foto_perfil_usuario;
    private $banner_perfil_usuario;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;

 // contrutor inicializa a classe e ou atributos
  public function __construct($db){
        $this->db = $db;
    }
// --------------- MÉTODOS DE BUSCA DE DADOS ---------------

    //  $id_perfil_usuario;
    //  $id_usuario;
    //  $descricao_perfil_usuario;
    //  $foto_perfil_usuario;
    //  $banner_perfil_usuario;
    //  $criado_em;
    //  $atualizado_em;
    //  $excluido_em;

 // metodo de buscar todos os Perfil Usuario
    function buscarPerfilUsuario(){
        $sql = "SELECT * FROM tbl_perfil_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os Perfil Usuario por usuario
    function buscarPerfilUsuarioPorUsuario($usuario){
        $sql = "SELECT * FROM tbl_perfil_usuario where id_cliente = :usuario and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario', $usuario); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// metodo de buscar todos os Perfil Usuario por data
    function buscarPerfilUsuarioPorCriacao($criado_em){
        $sql = "SELECT * FROM tbl_perfil_usuario where criado_em = :criado_em and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':criado_em', $criado_em); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // metodo de buscar todos os Perfil Usuario por status
     function buscarPerfilUsuarioPorStatus($status_agendamento){
        $sql = "SELECT * FROM tbl_perfil_usuario where status_agendamento = :status_agendamento and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status_agendamento', $status_agendamento); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Perfil Usuario inativos
    function buscarTodosPerfilUsuarioInativos(){
        $sql = "SELECT * FROM tbl_perfil_usuario where excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de buscar PerfilUsuario por ID
    function buscarPerfilUsuarioPorID($id){
        $sql = 'SELECT id_agendamento FROM tbl_perfil_usuario WHERE id_agendamento = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }



// --------------- MÉTODOS DE ALTERAÇÃO DE DADOS ---------------

   //  $id_perfil_usuario;
    //  $id_usuario;
    //  $descricao_perfil_usuario;
    //  $foto_perfil_usuario;
    //  $banner_perfil_usuario;
    //  $criado_em;
    //  $atualizado_em;
    //  $excluido_em;


// metodo de registrar PerfilUsuario

function registrarPerfilUsuario($descricao_perfil_usuario, $banner_perfil_usuario, $foto_perfil_usuario){
    $sql = 'INSERT INTO tbl_perfil_usuario (foto_perfil_usuario, descricao_perfil_usuario, banner_perfil_usuario)
    VALUES (:foto, :descricao, :banner)';
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':foto', $foto_perfil_usuario );
    $stmt->bindParam(':descricao', $descricao_perfil_usuario);
    $stmt->bindParam(':banner', $banner_perfil_usuario);
    if($stmt->execute()){
        return $this->db->lastInsertId();
        } else {   
            return false;
        }
    }
     
  // metodo de atualizar o PerfilUsuario // update
    function atualizarPerfilUsuario($id, $data_solicitada, $status_agendamento, $total_agendamento){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_perfil_usuario SET data_solicitada = :data_solicitada,
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

//metodo de inativar o PerfilUsuario // delete
function inativarPerfilUsuario($id){
    $dataatual = date('Y-m-d H:i:s');
    $sql = "UPDATE tbl_perfil_usuario SET excluido_em = :atual WHERE id_agendamento = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if ($stmt->execute()){
    return true;
    } else {
        return false;
    };
}

    //metodo de ativar o PerfilUsuario excluido 
function ativarPerfilUsuarioExcluido($id){
    $sql = "UPDATE tbl_perfil_usuario SET excluido_em = :atual WHERE id_agendamento = :id";
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