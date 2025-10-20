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

    // ---------------- MÉTODOS DE BUSCA ----------------

    // Buscar todas as avaliações ativas
    public function buscarAvaliacoes() {
        $sql = "SELECT * FROM tbl_avaliacao WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function totalDeAvaliacoes() {
    $sql = "SELECT COUNT(*) as total FROM tbl_avaliacao";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function totalDeAvaliacoesAtivas() {
    $sql = "SELECT COUNT(*) as total FROM tbl_avaliacao WHERE excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function totalDeAvaliacoesInativas() {
    $sql = "SELECT COUNT(*) as total FROM tbl_avaliacao WHERE excluido_em IS NOT NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
public function paginacao(int $pagina = 1, int $por_pagina = 10): array{
        $totalQuery = "SELECT COUNT(*) FROM `tbl_avaliacao`";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        $offset = ($pagina - 1) * $por_pagina;
        $dataQuery = "SELECT * FROM `tbl_avaliacao` LIMIT :limit OFFSET :offset";
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
    // Buscar avaliações excluídas
    public function buscarAvaliacoesExcluidas() {
        $sql = "SELECT * FROM tbl_avaliacao WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar avaliação por ID
    public function buscarAvaliacaoPorId($id) {
        $sql = "SELECT * FROM tbl_avaliacao 
                WHERE id_avaliacao = :id 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar avaliações por status (ativo, inativo, excluido)
    public function buscarAvaliacoesPorStatus($status) {
        $sql = "SELECT * FROM tbl_avaliacao 
                WHERE status_avaliacao = :status 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar avaliações por cliente
    public function buscarPorCliente($id_cliente) {
        $sql = "SELECT * FROM tbl_avaliacao 
                WHERE id_cliente = :id_cliente 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ---------------- MÉTODOS DE ALTERAÇÃO ----------------

    // Registrar nova avaliação
    public function registrarAvaliacao($id_cliente, $id_servico, $descricao, $nota, $status = 'ativo') {
        $sql = "INSERT INTO tbl_avaliacao 
                (id_cliente, id_servico, descricao_avaliacao, nota_avaliacao, status_avaliacao)
                VALUES (:id_cliente, :id_servico, :descricao, :nota, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':id_servico', $id_servico);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':nota', $nota);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    // Atualizar avaliação
    public function atualizarAvaliacao($id, $descricao, $nota, $status) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_avaliacao SET 
                    descricao_avaliacao = :descricao,
                    nota_avaliacao = :nota,
                    status_avaliacao = :status,
                    atualizado_em = :atualizado
                WHERE id_avaliacao = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':nota', $nota);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atualizado', $dataAtual);
        return $stmt->execute();
    }

    // Inativar avaliação (exclusão lógica)
    public function inativarAvaliacao($id) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_avaliacao 
                SET excluido_em = :excluido 
                WHERE id_avaliacao = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':excluido', $dataAtual);
        return $stmt->execute();
    }

    // Reativar avaliação excluída
    public function ativarAvaliacaoExcluida($id) {
        $sql = "UPDATE tbl_avaliacao 
                SET excluido_em = NULL 
                WHERE id_avaliacao = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}