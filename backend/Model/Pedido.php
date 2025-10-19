<?php

namespace App\Misu\Model;

use PDO;

/* Executa uma instrução preparada passando um array de valores */
class Pedido{
    private $id_pedido;
    private $id_cliente;
    private $id_servico;
    private $descricao_pedido;
    private $quantidade_solicitada;
    private $total_valor_pedido;
    private $status_pedido;
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
    public function buscarPedidos() {
        $sql = "SELECT * FROM tbl_pedido WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function totalDePedidos() {
    $sql = "SELECT COUNT(*) as total FROM tbl_pedido";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function totalDePedidosAtivos() {
    $sql = "SELECT COUNT(*) as total FROM tbl_pedido WHERE excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function totalDePedidosInativos() {
    $sql = "SELECT COUNT(*) as total FROM tbl_pedido WHERE excluido_em IS NOT NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
public function paginacao(int $pagina = 1, int $por_pagina = 10): array{
        $totalQuery = "SELECT COUNT(*) FROM `tbl_pedido`";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        $offset = ($pagina - 1) * $por_pagina;
        $dataQuery = "SELECT * FROM `tbl_pedido` LIMIT :limit OFFSET :offset";
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
    public function buscarPedidosExcluidos() {
        $sql = "SELECT * FROM tbl_pedido WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar orçamento por ID
    public function buscarPedidosPorId($id) {
        $sql = "SELECT * FROM tbl_pedido 
                WHERE id_pedido = :id 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar orçamentos por cliente
    public function buscarPedidosPorCliente($id_cliente) {
        $sql = "SELECT * FROM tbl_pedido 
                WHERE id_cliente = :id_cliente 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar orçamentos por categoria
    public function buscarPedidosPorServico($id_servico) {
        $sql = "SELECT * FROM tbl_pedido 
                WHERE id_servico = :id_servico 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_servico', $id_servico);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar orçamentos por status (ex: 'em análise', 'aprovado', 'rejeitado')
    public function buscarPedidosPorStatus($status) {
        $sql = "SELECT * FROM tbl_pedido 
                WHERE status_pedido = :status 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar orçamentos por período
    public function buscarPedidosPorPeriodo($dataInicio, $dataFim) {
        $sql = "SELECT * FROM tbl_pedido 
                WHERE data_pedido BETWEEN :inicio AND :fim 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':inicio', $dataInicio);
        $stmt->bindParam(':fim', $dataFim);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --------------- MÉTODOS DE ALTERAÇÃO DE DADOS ---------------

    // Registrar novo orçamento
    public function registrarPedidos($id_cliente, $id_servico, $descricao, $status) {
        $sql = "INSERT INTO tbl_pedido 
                (id_cliente, id_servico, descricao_pedido, status_pedido) 
                VALUES (:id_cliente, :id_servico, :descricao, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':id_servico', $id_servico);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    // Atualizar orçamento
    public function atualizarPedidos($id, $id_servico, $nome_servico, $descricao, $status) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_pedido SET 
                    id_servico = :id_servico,
                    nome_servico = :nome_servico,
                    descricao_pedido = :descricao,
                    status_pedido = :status,
                    atualizado_em = :atualizado
                WHERE id_pedido = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':id_servico', $id_servico);
        $stmt->bindParam(':nome_servico', $nome_servico);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atualizado', $dataAtual);
        return $stmt->execute();
    }

    // Inativar orçamento (exclusão lógica)
    public function inativarPedidos($id) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_pedido 
                SET excluido_em = :excluido 
                WHERE id_pedido = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':excluido', $dataAtual);
        return $stmt->execute();
    }

    // Reativar orçamento excluído
    public function ativarPedidosExcluido($id) {
        $sql = "UPDATE tbl_pedido 
                SET excluido_em = NULL 
                WHERE id_pedido = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}