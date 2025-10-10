<?php

namespace App\Misu\Model;

use PDO;

class ItemOrcamento{
    private $id_item_orcamento;
    private $id_orcamento;
    private $id_servico;
    private $id_cliente;
    private $valor_servico;
    private $quantidade_solicitada;
    private $descricao_item_orcamento;
    private $total_item_orcamento;
    private $status_item_orcamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;

 // contrutor inicializa a classe e ou atributos
  public function __construct($db){
        $this->db = $db;
    }

 // ---------------- MÉTODOS DE BUSCA ----------------

    // Buscar todos os ItemOrcamento ativos
    public function buscarItemOrcamentoAtivos() {
        $sql = "SELECT * FROM tbl_item_orcamento WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function totalDeItens() {
    $sql = "SELECT COUNT(*) as total FROM tbl_item_orcamento";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function totalDeItensAtivos() {
    $sql = "SELECT COUNT(*) as total FROM tbl_item_orcamento WHERE excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function totalDeItensInativos() {
    $sql = "SELECT COUNT(*) as total FROM tbl_item_orcamento WHERE excluido_em IS NOT NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
public function paginacao(int $pagina = 1, int $por_pagina = 10): array{
        $totalQuery = "SELECT COUNT(*) FROM `tbl_item_orcamento`";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        $offset = ($pagina - 1) * $por_pagina;
        $dataQuery = "SELECT * FROM `tbl_item_orcamento` LIMIT :limit OFFSET :offset";
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
    // Buscar ItemOrcamento excluídos
    public function buscarItemOrcamentoExcluidos() {
        $sql = "SELECT * FROM tbl_item_orcamento WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar item por ID
    public function buscarItemOrcamentoPorId($id) {
        $sql = "SELECT * FROM tbl_item_orcamento 
                WHERE id_item_orcamento = :id 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar por status (ativo, inativo, excluido)
    public function buscarItemOrcamentoPorStatus($status) {
        $sql = "SELECT * FROM tbl_item_orcamento 
                WHERE status_item_orcamento = :status 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar por orçamento
    public function buscarPorOrcamento($id_orcamento) {
        $sql = "SELECT * FROM tbl_item_orcamento 
                WHERE id_orcamento = :id_orcamento 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_orcamento', $id_orcamento);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ---------------- MÉTODOS DE ALTERAÇÃO ----------------

    // Registrar novo item
    public function registrarItemOrcamento($id_orcamento, $id_servico, $id_cliente, $valor_servico, $quantidade_solicitada, $descricao, $status) {
        $total = $valor_servico * $quantidade_solicitada;

        $sql = "INSERT INTO tbl_item_orcamento 
                (id_orcamento, id_servico, id_cliente, valor_servico, quantidade_solicitada, descricao_item_orcamento, total_item_orcamento, status_item_orcamento)
                VALUES (:id_orcamento, :id_servico, :id_cliente, :valor_servico, :quantidade, :descricao, :total, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_orcamento', $id_orcamento);
        $stmt->bindParam(':id_servico', $id_servico);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':valor_servico', $valor_servico);
        $stmt->bindParam(':quantidade', $quantidade_solicitada);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    // Atualizar item
    public function atualizarItemOrcamento($id, $valor_servico, $quantidade_solicitada, $descricao, $status) {
        $total = $valor_servico * $quantidade_solicitada;
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_item_orcamento SET 
                    valor_servico = :valor_servico,
                    quantidade_solicitada = :quantidade,
                    descricao_item_orcamento = :descricao,
                    total_item_orcamento = :total,
                    status_item_orcamento = :status,
                    atualizado_em = :atualizado
                WHERE id_item_orcamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':valor_servico', $valor_servico);
        $stmt->bindParam(':quantidade', $quantidade_solicitada);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atualizado', $dataAtual);
        return $stmt->execute();
    }

    // Inativar (exclusão lógica)
    public function inativarItemOrcamento($id) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_item_orcamento 
                SET excluido_em = :excluido 
                WHERE id_item_orcamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':excluido', $dataAtual);
        return $stmt->execute();
    }

    // Reativar item excluído
    public function ativarItemOrcamentoExcluido($id) {
        $sql = "UPDATE tbl_item_orcamento 
                SET excluido_em = NULL 
                WHERE id_item_orcamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}