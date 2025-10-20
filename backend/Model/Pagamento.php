<?php

namespace App\Misu\Model;

use PDO;


/* Executa uma instrução preparada passando um array de valores */
class Pagamento{
    private $id_pagamento;
    private $id_cliente;
    private $id_pedido;
    private $total_devedor;
    private $status_pagamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;

 // contrutor inicializa a classe e ou atributos
  public function __construct($db){
        $this->db = $db;
    }
// --------------- MÉTODOS DE BUSCA DE DADOS ---------------

    // Buscar todos os pagamentos
    public function buscarPagamentos() {
        $sql = "SELECT * FROM tbl_pagamento WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function totalDePagamentos() {
    $sql = "SELECT COUNT(*) as total FROM tbl_pagamento";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function totalDePagamentosAtivos() {
    $sql = "SELECT COUNT(*) as total FROM tbl_pagamento WHERE excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function totalDePagamentosInativos() {
    $sql = "SELECT COUNT(*) as total FROM tbl_pagamento WHERE excluido_em IS NOT NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
public function paginacao(int $pagina = 1, int $por_pagina = 10): array{
        $totalQuery = "SELECT COUNT(*) FROM `tbl_pagamento`";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        $offset = ($pagina - 1) * $por_pagina;
        $dataQuery = "SELECT * FROM `tbl_pagamento` LIMIT :limit OFFSET :offset";
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
    // Buscar pagamentos excluídos
    public function buscarPagamentosExcluidos() {
        $sql = "SELECT * FROM tbl_pagamento WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar pagamento por ID
    public function buscarPagamentoPorId($id) {
        $sql = "SELECT * FROM tbl_pagamento 
                WHERE id_pagamento = :id AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar pagamentos por status (ex: 'pago', 'pendente', 'cancelado')
    public function buscarPagamentosPorStatus($status) {
        $sql = "SELECT * FROM tbl_pagamento 
                WHERE status_pagamento = :status 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar pagamentos por cliente
    public function buscarPagamentosPorCliente($id_cliente) {
        $sql = "SELECT * FROM tbl_pagamento 
                WHERE id_cliente = :id_cliente 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar pagamentos por intervalo de datas
    public function buscarPagamentosPorPeriodo($dataInicio, $dataFim) {
        $sql = "SELECT * FROM tbl_pagamento 
                WHERE data_pagamento BETWEEN :inicio AND :fim 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':inicio', $dataInicio);
        $stmt->bindParam(':fim', $dataFim);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --------------- MÉTODOS DE ALTERAÇÃO DE DADOS ---------------

    // Registrar novo pagamento
    public function registrarPagamento($id_cliente, $total, $status, $data_pagamento) {
        $sql = "INSERT INTO tbl_pagamento 
                (id_cliente, total_devedor, status_pagamento, data_pagamento) 
                VALUES (:id_cliente, :total, :status, :data_pagamento)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':data_pagamento', $data_pagamento);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    // Atualizar pagamento
    public function atualizarPagamento($id, $total, $status, $data_pagamento) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_pagamento SET 
                    total_devedor = :total,
                    status_pagamento = :status,
                    data_pagamento = :data_pagamento,
                    atualizado_em = :atualizado
                WHERE id_pagamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':data_pagamento', $data_pagamento);
        $stmt->bindParam(':atualizado', $dataAtual);
  if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    // Inativar pagamento (exclusão lógica)
    public function inativarPagamento($id) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_pagamento 
                SET excluido_em = :excluido 
                WHERE id_pagamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':excluido', $dataAtual);
         if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    // Reativar pagamento excluído
    public function ativarPagamentoExcluido($id) {
        $sql = "UPDATE tbl_pagamento 
                SET excluido_em = NULL 
                WHERE id_pagamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
          if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
}

