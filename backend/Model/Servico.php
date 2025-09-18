<?php
class Servico{
    private $id_servico;
    private $id_categoria;
    private $nome_servico;
    private $descricao_servico;
    private $valor_servico;
    private $foto_servico;
    private $status_servico;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    //construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }
 
/* Executa uma instrução preparada passando um array de valores */
function BuscaServico($db){
   
    $sql = 'SELECT nome_servico FROM tbl_servico';
    $statment = $this->db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $statment->execute();
    return $resultado = $statment->fetchAll();
 
function RegistrarServico($db, $nome, $descricao, $valor, $foto, $status = null){
    $sql = 'INSERT INTO tbl_servico (nome_servico, descricao_servico, valor_servico, foto_servico)
    VALUES (:nome, :descricao, :valor, :foto, :status)';
    $statment = $this->db->prepare($sql);
    $statment->bindParam(':nome', $nome);
    $statment->bindParam(':descricao', $descricao);
    $statment->bindParam(':valor', $valor);
    $statment->bindParam(':foto', $foto);
    $statment->bindParam(':status', $status);
    if($statment->execute()){
        return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
function atualizarServico($id, $nome, $descricao, $valor, $foto, $status = null){
        $sql = "UPDATE tbl_servico SET nome_servico = :nome";
       
        if($descricao){
            $sql .= ", descricao_servico = :descricao";
        }
        if($valor){
            $sql .= ", valor_servico = :valor";
        }
        if($foto){
            $sql .= ", foto_servico = :foto";
        }
        if($status){
            $sql .= ", status_servico = :status";
        }
        $sql .= ", atualizado_em = NOW() WHERE id_servico = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
       
        if($nome){
            $stmt->bindParam(':nome', $nome);
        }
        if($descricao){
            $stmt->bindParam(':descricao', $descricao);
        }
        if($valor){
            $stmt->bindParam(':valor', $valor);
        }
        if($foto){
            $stmt->bindParam(':foto', $foto);
        }
        if($status){
            $stmt->bindParam(':status', $status);
        }
        return $stmt->execute();
    }
    function deletarServico($id){
        $sql = "UPDATE tbl_servico SET excluido_em = NOW() WHERE id_servico = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
function BuscaServicoPorID($id){
    $sql = 'SELECT nome_servico, descricao_servico, valor_servico FROM tbl_servico WHERE id_servico = :id';
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
   
}
}
?>