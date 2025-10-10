<?php
namespace App\Misu\Model;

use PDO;



/* Executa uma instrução preparada passando um array de valores */
class PerfilUsuario{
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

    // Buscar todos os perfis ativos
    function buscarPerfisAtivos() {
        $sql = "SELECT * FROM tbl_perfil_usuario WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar perfis inativos
    function buscarPerfisInativos($status) {
        $sql = "SELECT * FROM tbl_perfil_usuario WHERE status_perfil_usuario = 'inativo' 
            AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
         $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar perfil por ID
    function buscarPerfisPorId($id) {
        $sql = "SELECT * FROM tbl_perfil_usuario WHERE id_perfil_usuario = :id AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar perfil por ID de usuário
    function buscarPerfisPorUsuario($id_usuario) {
        $sql = "SELECT * FROM tbl_perfil_usuario WHERE id_usuario = :id_usuario AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


// metodo de buscar todos os Perfil Usuario por data
    function buscarPerfisUsuarioPorCriacao($criado_em){
        $sql = "SELECT * FROM tbl_perfil_usuario where criado_em = :criado_em and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':criado_em', $criado_em); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


//     // Buscar perfil por Status
//     public function buscarPerfisPorStatus($status) {
//     $sql = "SELECT * FROM tbl_perfil_usuario WHERE status_perfil_usuario = :status AND excluido_em IS NULL";
//     $stmt = $this->db->prepare($sql);
//     $stmt->bindParam(':status', $status);
//     $stmt->execute();
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }


    
   //  $id_perfil_usuario;
    //  $id_usuario;
    //  $descricao_perfil_usuario;
    //  $foto_perfil_usuario;
    //  $banner_perfil_usuario;
    //  $criado_em;
    //  $atualizado_em;
    //  $excluido_em;


  


// --------------- MÉTODOS DE ALTERAÇÃO DE DADOS ---------------

       // Registrar novo perfil de usuário
    function registrarPerfis($id_usuario, $descricao, $foto, $banner) {
        $sql = "INSERT INTO tbl_perfil_usuario 
        (id_usuario, descricao_perfil_usuario, foto_perfil_usuario, banner_perfil_usuario)
        VALUES (:id_usuario, :descricao, :foto, :banner)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':banner', $banner);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
     
    // Atualizar perfil existente
    function atualizarPerfis($id, $descricao, $foto, $banner) {
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_perfil_usuario 
                SET descricao_perfil_usuario = :descricao,
                    foto_perfil_usuario = :foto,
                    banner_perfil_usuario = :banner,
                    atualizado_em = :atual
                WHERE id_perfil_usuario = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':banner', $banner);
        $stmt->bindParam(':atual', $dataatual);
          if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

 // Inativar perfil (soft delete)
    function inativarPerfil($id) {
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_perfil_usuario SET excluido_em = :atual WHERE id_perfil_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
         if ($stmt->execute()){
    return true;
    } else {
        return false;
    };
    }

    // Reativar perfil inativo
    function ativarPerfil($id) {
        $sql = "UPDATE tbl_perfil_usuario SET excluido_em = NULL WHERE id_perfil_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()){
    return true;
    } else {
        return false;
    };
    }

}

