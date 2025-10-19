<?php

namespace App\Misu\Model;

use PDO;

/* Executa uma instrução preparada passando um array de valores */
class Servico{
    private $id_servico;
    private $nome_servico;
    private $descricao_servico;
    private $categoria_servico;
    private $foto_servico;
    private $valor_servico;
    private $status_servico;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;

 // contrutor inicializa a classe e ou atributos / inicializa a conexão com o banco
  public function __construct($db){
        $this->db = $db;
    }

// --------------- MÉTODOS DE BUSCA DE DADOS ---------------

// Total de serviços
public function totalDeServicos() {
    $sql = "SELECT COUNT(*) as total FROM tbl_servico";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

// Total de serviços ativos
public function totalDeServicosAtivos() {
    $sql = "SELECT COUNT(*) as total FROM tbl_servico WHERE excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

// Total de serviços inativos/excluídos
public function totalDeServicosInativos() {
    $sql = "SELECT COUNT(*) as total FROM tbl_servico WHERE excluido_em IS NOT NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function paginacao(int $pagina = 1, int $por_pagina = 10): array{
        $totalQuery = "SELECT COUNT(*) FROM `tbl_servico`";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        $offset = ($pagina - 1) * $por_pagina;
        $dataQuery = "SELECT * FROM `tbl_servico` LIMIT :limit OFFSET :offset";
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

// Buscar serviço por ID
    function buscarServicosPorId($id){
        $sql = "SELECT * FROM tbl_servico WHERE id_servico = :id AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    // Buscar serviço por nome
    function buscarServicosPorNome($nome){
        $sql = "SELECT * FROM tbl_servico WHERE nome_servico LIKE :nome AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $nome = "%$nome%";
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar serviços por categoria
    function buscarServicosPorCategoria($categoria){
        $sql = "SELECT * FROM tbl_servico WHERE categoria_servico = :categoria AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

// --------------- MÉTODOS DE ALTERAÇÃO DE DADOS ---------------


        // Registrar novo serviço / create
    function registrarServicos($categoria, $nome, $descricao, $valor, $foto, $status){
        $sql = "INSERT INTO tbl_servico 
        (categoria_servico = :categoria, nome_servico, descricao_servico, valor_servico, foto_servico, status_servico) 
        VALUES (:categoria, :nome, :descricao, :valor, :foto, :status)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':status', $status);
        
        if($stmt->execute()){
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    // Atualizar serviço existente / update
    function atualizarServicos($id, $categoria, $nome, $descricao, $valor, $foto, $status){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_servico 
                SET categoria_servico = :categoria,
                    nome_servico = :nome,
                    descricao_servico = :descricao,
                    valor_servico = :valor,
                    foto_servico = :foto,
                    status_servico = :status,
                    atualizado_em = :atual
                WHERE id_servico = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }


    // Inativar serviço (soft delete)
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

    // Reativar serviço inativo
    function ativarServicos($id){
        $dataatual = NULL;
        $sql = "UPDATE tbl_servico SET excluido_em = NULL WHERE id_servico = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
         if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    function listarCategorias() {
        $sql = "SELECT * FROM tbl_servico WHERE categoria_servico = :categoria AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}