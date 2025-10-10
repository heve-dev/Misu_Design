<?php

namespace App\Misu\Model;

use PDO;

class ItemAgendamento{
    private $id_item_agendamento;
    private $id_servico;
    private $id_cliente;
    private $valor_servico;
    private $quantidade_solicitada;
    private $descricao_item_item_agendamento;
    private $total_item;
    private $status_item_item_agendamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
 // contrutor inicializa a classe e ou atributos
  public function __construct($db){
        $this->db = $db;
    }
// ---------------- MÉTODOS DE BUSCA ----------------

    // Buscar todos os itens ativos
    public function buscarItensAtivos() {
        $sql = "SELECT * FROM tbl_item_agendamento WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar itens excluídos
    public function buscarItensExcluidos() {
        $sql = "SELECT * FROM tbl_item_agendamento WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar item por ID
    public function buscarItemPorId($id) {
        $sql = "SELECT * FROM tbl_item_agendamento 
                WHERE id_item_agendamento = :id 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar por status (ativo, inativo, excluido)
    public function buscarItensPorStatus($status) {
        $sql = "SELECT * FROM tbl_item_agendamento 
                WHERE status_item_item_agendamento = :status 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar por cliente
    public function buscarPorCliente($id_cliente) {
        $sql = "SELECT * FROM tbl_item_agendamento 
                WHERE id_cliente = :id_cliente 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ---------------- MÉTODOS DE ALTERAÇÃO ----------------

    // Registrar novo item
    public function registrarItem($id_servico, $id_cliente, $valor_servico, $quantidade_solicitada, $descricao, $status) {
        $total = $valor_servico * $quantidade_solicitada;

        $sql = "INSERT INTO tbl_item_agendamento 
                (id_servico, id_cliente, valor_servico, quantidade_solicitada, descricao_item_item_agendamento, total_item, status_item_item_agendamento)
                VALUES (:id_servico, :id_cliente, :valor_servico, :quantidade, :descricao, :total, :status)";
        $stmt = $this->db->prepare($sql);
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
    public function atualizarItem($id, $valor_servico, $quantidade_solicitada, $descricao, $status) {
        $total = $valor_servico * $quantidade_solicitada;
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_item_agendamento SET 
                    valor_servico = :valor_servico,
                    quantidade_solicitada = :quantidade,
                    descricao_item_item_agendamento = :descricao,
                    total_item = :total,
                    status_item_item_agendamento = :status,
                    atualizado_em = :atualizado
                WHERE id_item_agendamento = :id";
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
    public function inativarItem($id) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_item_agendamento 
                SET excluido_em = :excluido 
                WHERE id_item_agendamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':excluido', $dataAtual);
        return $stmt->execute();
    }

    // Reativar item excluído
    public function ativarItemExcluido($id) {
        $sql = "UPDATE tbl_item_agendamento 
                SET excluido_em = NULL 
                WHERE id_item_agendamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}