<?php

namespace App\Misu\Model;

use PDO;

class Usuario{
    private $id_usuario;
    private $nome_usuario;
    private $telefone_usuario;
    private $email_usuario;
    private $senha_usuario;
    private $foto_usuario;
    private $descricao_usuario;
    private $tipo_usuario;
    private $status_usuario;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;

 // contrutor inicializa a classe e ou atributos
  public function __construct($db){
        $this->db = $db;
    }


// --------------- MÉTODOS DE BUSCA DE DADOS ---------------

    // Buscar total de usuarios ativos/inativos etc
 function totalDeUsuarios() {
    $sql = "SELECT count(*) as total FROM tbl_usuario";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
 // Buscar total de usuarios ativos
    function totalDeUsuariosAtivos(){
        $sql = "SELECT count(*) as total FROM tbl_usuario where excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
 // Buscar total de usuarios inativos
      function totalDeUsuariosInativos(){
        $sql = "SELECT count(*) as total FROM tbl_usuario where excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Buscar todos os usuários especificos
    function buscarUsuarios() {
        $sql = "SELECT * FROM tbl_usuario WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        // Buscar todos os usuários inativos
    function buscarUsuariosInativos() {
        $sql = "SELECT * FROM tbl_usuario WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar usuário por ID
    function buscarUsuariosPorId($id) {
        $sql = "SELECT * FROM tbl_usuario WHERE id_usuario = :id AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

// Buscar usuários por páginas limitadas -----------
    public function paginacao(int $pagina = 1, int $por_pagina = 10): array{
        $totalQuery = "SELECT COUNT(*) FROM tbl_usuario";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        $offset = ($pagina - 1) * $por_pagina;
        $dataQuery = "SELECT * FROM `tbl_usuario` LIMIT :limit OFFSET :offset";
        $dataStmt = $this->db->prepare($dataQuery);
        $dataStmt->bindValue(':limit', $por_pagina, PDO::PARAM_INT);
        $dataStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $dataStmt->execute();
        $dados = $dataStmt->fetchAll(PDO::FETCH_ASSOC);
        $lastPage = ceil($total_de_registros / $por_pagina);
 
        return [
            'data' => $dados,
            'total' => (int) $total_de_registros,
            'por_pagina' => (int) $por_pagina,
            'pagina_atual' => (int) $pagina,
            'ultima_pagina' => (int) $lastPage,
            'de' => $offset + 1,
            'para' => $offset + count($dados)
        ];
    }
//---------------------------------

    // Buscar usuário por e-mail (ativo)
    function buscarUsuariosPorEmail($email) {
        $sql = "SELECT * FROM tbl_usuario WHERE email_usuario = :email AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar usuário por e-mail (inativo)
    function buscarUsuariosPorEmailInativo($email) {
        $sql = "SELECT * FROM tbl_usuario WHERE email_usuario = :email AND excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar usuário por e-mail (ativo)
    function buscarUsuariosPorTelefone($telefone) {
        $sql = "SELECT * FROM tbl_usuario WHERE telefone_usuario = :telefone AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



// --------------- MÉTODOS DE ALTERAÇÃO DE DADOS ---------------

    // Registrar novo usuário / create
    function registrarUsuarios($nome, $telefone, $email, $senha, $tipo = 'usuario', $status ='ativo', $foto = '', $descricao = '') {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO tbl_usuario 
        (nome_usuario, telefone_usuario, email_usuario, senha_usuario, foto_usuario, descricao_usuario, tipo_usuario, status_usuario) 
        VALUES (:nome, :telefone, :email, :senha, :foto, :descricao, :tipo, :status)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senhaHash);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':status', $status);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
    function atualizarUsuarios($id, $nome, $telefone, $email, $senha, $foto, $descricao, $tipo, $status) {
        $dataatual = date('Y-m-d H:i:s');
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "UPDATE tbl_usuario SET 
                    nome_usuario = :nome,
                    telefone_usuario = :telefone,
                    email_usuario = :email,
                    senha_usuario = :senha,
                    foto_usuario = :foto,
                    descricao_usuario = :descricao,
                    tipo_usuario = :tipo,
                    status_usuario = :status,
                    atualizado_em = :atual
                WHERE id_usuario = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senhaHash);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atual', $dataatual);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    // Inativar usuário (soft delete)
    function inativarUsuarios($id) {
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_usuario SET excluido_em = :atual WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
         if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    // Reativar usuário inativo
    function ativarUsuarios($id) {
         $dataatual = NULL;
        $sql = "UPDATE tbl_usuario SET excluido_em = NULL WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function checarCredenciais(string $email, string $senha) {
        $usuario = $this->buscarUsuariosPorEmail($email);
        if (count($usuario) !== 1) {
            return false; // Usuário não encontrado ou múltiplos usuários com o mesmo email
        }
        $usuario = $usuario[0];
        if (password_verify($senha, $usuario['senha_usuario'])) {
            return $usuario; // Credenciais válidas
        } 
            return false; // Senha incorreta
        }
}
