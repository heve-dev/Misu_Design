<?php

namespace App\Misu\Model;

use PDO;

/* Executa uma instrução preparada passando um array de valores */
class Orcamento{
    private $id_orcamento;
    private $id_cliente;
    private $id_categoria;
    private $id_pagamento;
    private $descricao_orcamento;
    private $status_orcamento;
    private $data_orcamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;

 // contrutor inicializa a classe e ou atributos
  public function __construct($db){
        $this->db = $db;
    }

 // --------------- MÉTODOS DE BUSCA DE DADOS ---------------

    // Buscar todos os orçamentos
    public function buscarOrcamentos() {
        $sql = "SELECT * FROM tbl_orcamento WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function totalDeOrcamentos() {
    $sql = "SELECT COUNT(*) as total FROM tbl_orcamento";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function totalDeOrcamentosAtivos() {
    $sql = "SELECT COUNT(*) as total FROM tbl_orcamento WHERE excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function totalDeOrcamentosInativos() {
    $sql = "SELECT COUNT(*) as total FROM tbl_orcamento WHERE excluido_em IS NOT NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
public function paginacao(int $pagina = 1, int $por_pagina = 10): array{
        $totalQuery = "SELECT COUNT(*) FROM `tbl_orcamento`";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        $offset = ($pagina - 1) * $por_pagina;
        $dataQuery = "SELECT * FROM `tbl_orcamento` LIMIT :limit OFFSET :offset";
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
    // Buscar orçamentos excluídos
    public function buscarOrcamentosExcluidos() {
        $sql = "SELECT * FROM tbl_orcamento WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar orçamento por ID
    public function buscarOrcamentoPorId($id) {
        $sql = "SELECT * FROM tbl_orcamento 
                WHERE id_orcamento = :id 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar orçamentos por cliente
    public function buscarOrcamentosPorCliente($id_cliente) {
        $sql = "SELECT * FROM tbl_orcamento 
                WHERE id_cliente = :id_cliente 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar orçamentos por categoria
    public function buscarOrcamentosPorCategoria($id_categoria) {
        $sql = "SELECT * FROM tbl_orcamento 
                WHERE id_categoria = :id_categoria 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar orçamentos por status (ex: 'em análise', 'aprovado', 'rejeitado')
    public function buscarOrcamentosPorStatus($status) {
        $sql = "SELECT * FROM tbl_orcamento 
                WHERE status_orcamento = :status 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar orçamentos por período
    public function buscarOrcamentosPorPeriodo($dataInicio, $dataFim) {
        $sql = "SELECT * FROM tbl_orcamento 
                WHERE data_orcamento BETWEEN :inicio AND :fim 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':inicio', $dataInicio);
        $stmt->bindParam(':fim', $dataFim);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --------------- MÉTODOS DE ALTERAÇÃO DE DADOS ---------------

    // Registrar novo orçamento
    public function registrarOrcamento($id_cliente, $id_categoria, $id_pagamento, $descricao, $status, $data_orcamento) {
        $sql = "INSERT INTO tbl_orcamento 
                (id_cliente, id_categoria, id_pagamento, descricao_orcamento, status_orcamento, data_orcamento) 
                VALUES (:id_cliente, :id_categoria, :id_pagamento, :descricao, :status, :data_orcamento)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':id_pagamento', $id_pagamento);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':data_orcamento', $data_orcamento);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    // Atualizar orçamento
    public function atualizarOrcamento($id, $id_categoria, $id_pagamento, $descricao, $status, $data_orcamento) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_orcamento SET 
                    id_categoria = :id_categoria,
                    id_pagamento = :id_pagamento,
                    descricao_orcamento = :descricao,
                    status_orcamento = :status,
                    data_orcamento = :data_orcamento,
                    atualizado_em = :atualizado
                WHERE id_orcamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':id_pagamento', $id_pagamento);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':data_orcamento', $data_orcamento);
        $stmt->bindParam(':atualizado', $dataAtual);
        return $stmt->execute();
    }

    // Inativar orçamento (exclusão lógica)
    public function inativarOrcamento($id) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_orcamento 
                SET excluido_em = :excluido 
                WHERE id_orcamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':excluido', $dataAtual);
        return $stmt->execute();
    }

    // Reativar orçamento excluído
    public function ativarOrcamentoExcluido($id) {
        $sql = "UPDATE tbl_orcamento 
                SET excluido_em = NULL 
                WHERE id_orcamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}