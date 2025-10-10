<?php
namespace App\Misu\Model;

use PDO;

$usuario = new Usuario($db);
$agendamento = new Agendamento($db);

/* Executa uma instrução preparada passando um array de valores */
class Agendamento{
    private $id_agendamento;
    private $id_cliente;
    private $id_servico;
    private $data_solicitada;
    private $total_agendamento;
    private $status_agendamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    //construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }
// ---------------- MÉTODOS DE BUSCA ----------------

    // Buscar todos os agendamentos ativos
    public function buscarAgendamentosAtivos() {
        $sql = "SELECT * FROM tbl_agendamento WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function totalDeAgendamentos() {
    $sql = "SELECT COUNT(*) as total FROM tbl_agendamento";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function totalDeAgendamentosAtivos() {
    $sql = "SELECT COUNT(*) as total FROM tbl_agendamento WHERE excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function totalDeAgendamentosInativos() {
    $sql = "SELECT COUNT(*) as total FROM tbl_agendamento WHERE excluido_em IS NOT NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
public function paginacao(int $pagina = 1, int $por_pagina = 10): array{
        $totalQuery = "SELECT COUNT(*) FROM `tbl_agendamento`";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        $offset = ($pagina - 1) * $por_pagina;
        $dataQuery = "SELECT * FROM `tbl_agendamento` LIMIT :limit OFFSET :offset";
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
    // Buscar agendamentos excluídos
    public function buscarAgendamentosExcluidos() {
        $sql = "SELECT * FROM tbl_agendamento WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar agendamento por ID
    public function buscarAgendamentoPorId($id) {
        $sql = "SELECT * FROM tbl_agendamento 
                WHERE id_agendamento = :id 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar agendamentos por status (ativo, inativo, excluido)
    public function buscarAgendamentosPorStatus($status) {
        $sql = "SELECT * FROM tbl_agendamento 
                WHERE status_agendamento = :status 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar agendamentos por cliente
    public function buscarPorCliente($id_cliente) {
        $sql = "SELECT * FROM tbl_agendamento 
                WHERE id_cliente = :id_cliente 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ---------------- MÉTODOS DE ALTERAÇÃO ----------------

    // Registrar novo agendamento
    public function registrarAgendamento($id_cliente, $id_servico, $data_solicitada, $total_agendamento, $status = 'ativo') {
        $sql = "INSERT INTO tbl_agendamento 
                (id_cliente, id_servico, data_solicitada, total_agendamento, status_agendamento)
                VALUES (:id_cliente, :id_servico, :data_solicitada, :total_agendamento, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':id_servico', $id_servico);
        $stmt->bindParam(':data_solicitada', $data_solicitada);
        $stmt->bindParam(':total_agendamento', $total_agendamento);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    // Atualizar agendamento
    public function atualizarAgendamento($id, $id_servico, $data_solicitada, $total_agendamento, $status) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_agendamento SET 
                    id_servico = :id_servico,
                    data_solicitada = :data_solicitada,
                    total_agendamento = :total_agendamento,
                    status_agendamento = :status,
                    atualizado_em = :atualizado
                WHERE id_agendamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':id_servico', $id_servico);
        $stmt->bindParam(':data_solicitada', $data_solicitada);
        $stmt->bindParam(':total_agendamento', $total_agendamento);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atualizado', $dataAtual);
        return $stmt->execute();
    }

    // Inativar (exclusão lógica)
    public function inativarAgendamento($id) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_agendamento 
                SET excluido_em = :excluido 
                WHERE id_agendamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':excluido', $dataAtual);
        return $stmt->execute();
    }

    // Reativar agendamento excluído
    public function ativarAgendamentoExcluido($id) {
        $sql = "UPDATE tbl_agendamento 
                SET excluido_em = NULL 
                WHERE id_agendamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}