<?php
namespace App\Misu\Model;

use PDO;


class Contato{
    private $id_contato;
    private $nome_contato;
    private $telefone_contato;
    private $email_contato;
    private $mensagem_contato;
    private $status_contato;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
 // contrutor inicializa a classe e ou atributos
  public function __construct($db){
        $this->db = $db;
    }

  // ---------------- MÉTODOS DE BUSCA ----------------

    // Buscar todos os contatos ativos
    public function buscarContatosAtivos() {
        $sql = "SELECT * FROM tbl_contato WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar contatos excluídos
    public function buscarContatosExcluidos() {
        $sql = "SELECT * FROM tbl_contato WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar contato por ID
    public function buscarContatoPorId($id) {
        $sql = "SELECT * FROM tbl_contato 
                WHERE id_contato = :id 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar contatos por status (ativo, pendente, resolvido, etc.)
    public function buscarContatosPorStatus($status) {
        $sql = "SELECT * FROM tbl_contato 
                WHERE status_contato = :status 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ---------------- MÉTODOS DE ALTERAÇÃO ----------------

    // Registrar novo contato
    public function registrarContato($nome, $telefone, $email, $mensagem, $status = 'pendente') {
        $sql = "INSERT INTO tbl_contato 
                (nome_contato, telefone_contato, email_contato, mensagem_contato, status_contato)
                VALUES (:nome, :telefone, :email, :mensagem, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mensagem', $mensagem);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    // Atualizar contato (ex: marcar como respondido ou alterar dados)
    public function atualizarContato($id, $nome, $telefone, $email, $mensagem, $status) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_contato SET 
                    nome_contato = :nome,
                    telefone_contato = :telefone,
                    email_contato = :email,
                    mensagem_contato = :mensagem,
                    status_contato = :status,
                    atualizado_em = :atualizado
                WHERE id_contato = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mensagem', $mensagem);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atualizado', $dataAtual);
        return $stmt->execute();
    }

    // Inativar (exclusão lógica)
    public function inativarContato($id) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_contato 
                SET excluido_em = :excluido 
                WHERE id_contato = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':excluido', $dataAtual);
        return $stmt->execute();
    }

    // Reativar contato excluído
    public function ativarContatoExcluido($id) {
        $sql = "UPDATE tbl_contato 
                SET excluido_em = NULL 
                WHERE id_contato = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}