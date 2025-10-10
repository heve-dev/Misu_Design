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

    // ---------------- MÉTODOS DE BUSCA ----------------

    // Buscar todas as categorias ativas
    public function buscarCategoriasAtivas() {
        $sql = "SELECT * FROM tbl_categoria WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function totalDeCategorias() {
    $sql = "SELECT COUNT(*) as total FROM tbl_categoria";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function totalDeCategoriasAtivas() {
    $sql = "SELECT COUNT(*) as total FROM tbl_categoria WHERE excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function totalDeCategoriasInativas() {
    $sql = "SELECT COUNT(*) as total FROM tbl_categoria WHERE excluido_em IS NOT NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
public function paginacao(int $pagina = 1, int $por_pagina = 10): array{
        $totalQuery = "SELECT COUNT(*) FROM `tbl_categoria`";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        $offset = ($pagina - 1) * $por_pagina;
        $dataQuery = "SELECT * FROM `tbl_categoria` LIMIT :limit OFFSET :offset";
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
    // Buscar categorias excluídas
    public function buscarCategoriasExcluidas() {
        $sql = "SELECT * FROM tbl_categoria WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar categoria por ID
    public function buscarCategoriaPorId($id) {
        $sql = "SELECT * FROM tbl_categoria 
                WHERE id_categoria = :id 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar categorias pelo nome (busca parcial)
    public function buscarCategoriaPorNome($nome) {
        $sql = "SELECT * FROM tbl_categoria 
                WHERE nome_categoria LIKE :nome 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $nomeBusca = "%$nome%";
        $stmt->bindParam(':nome', $nomeBusca);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ---------------- MÉTODOS DE ALTERAÇÃO ----------------

    // Criar nova categoria
    public function criarCategoria($nome, $descricao, $foto = null) {
        $sql = "INSERT INTO tbl_categoria 
                (nome_categoria, descricao_categoria, foto_categoria)
                VALUES (:nome, :descricao, :foto)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':foto', $foto);
        return $stmt->execute();
    }

    // Atualizar categoria existente
    public function atualizarCategoria($id, $nome, $descricao, $foto = null) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_categoria SET 
                    nome_categoria = :nome,
                    descricao_categoria = :descricao,
                    foto_categoria = :foto,
                    atualizado_em = :atualizado
                WHERE id_categoria = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':atualizado', $dataAtual);
        return $stmt->execute();
    }

    // Inativar (exclusão lógica)
    public function inativarCategoria($id) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_categoria 
                SET excluido_em = :excluido 
                WHERE id_categoria = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':excluido', $dataAtual);
        return $stmt->execute();
    }

    // Reativar categoria excluída
    public function ativarCategoriaExcluida($id) {
        $sql = "UPDATE tbl_categoria 
                SET excluido_em = NULL 
                WHERE id_categoria = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}