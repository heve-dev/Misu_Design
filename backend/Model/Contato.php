<?php
include_once 'backend/Database/Database.php';
include_once 'backend/Model/Contato.php';

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
    //construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }
 
/* Executa uma instrução preparada passando um array de valores */
function buscaContato($db){
    $sql = 'SELECT id_contato, nome_contato, email_contato, telefone_contato, mensagem_contato FROM tbl_contato ';
    $statment = $db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $statment->execute();
    return $resultado = $statment->fetchAll();
}

function BuscaContatoPorEmail($db,$email){
    $sql = 'SELECT nome_contato, email_contato FROM tbl_contato WHERE email_contato = :email';
    $statment = $db->prepare($sql);
    $statment->bindParam(':email', $email);
    $statment->execute();
    return $resultado = $statment->fetchAll();
   
}
function registrarContato($db, $nome, $email, $telefone, $mensagem){
    $sql = 'INSERT INTO tbl_contato (nome_contato, email_contato, telefone_contato, mensagem_contato)
    VALUES (:nome, :email, :telefone, :mensagem)';
    $statment = $db->prepare($sql);
    $statment->bindParam(':nome', $nome);
    $statment->bindParam(':email', $email);
    $statment->bindParam(':telefone', $telefone);
    $statment->bindParam(':mensagem', $mensagem);
    if($statment->execute()){
        return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

function atualizarContato($id, $nome, $email, $telefone, $mensagem = null, $tipo = null, $status = null){
        $sql = "UPDATE tbl_contato SET nome_contato = :nome, email_contato = :email";
        if($nome){
            $sql .= ", nome_contato = :nome";
        }
        if($email){
            $sql .= ", email_contato = :email";
        }
        if($mensagem){
            $sql .= ", mensagem_contato = :mensagem";
        }
        if($telefone){
            $sql .= ", telefone_contato = :telefone";
        }
        if($tipo){
            $sql .= ", tipo_contato = :tipo";
        }
        if($status){
            $sql .= ", status_contato = :status";
        }
        $sql .= ", atualizado_em = NOW() WHERE id_contato = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':mensagem', $mensagem);
        if($nome){
            $stmt->bindParam(':nome', $nome);
        }
        if($email){
            $stmt->bindParam(':email', $email);
        }
        if($telefone){
            $stmt->bindParam(':telefone', $telefone);
        }

        if($mensagem){
            $stmt->bindParam(':mensagem', $mensagem);
        }
        if($tipo){
            $stmt->bindParam(':tipo', $tipo);
        }
        if($status){
            $stmt->bindParam(':status', $status);
        }
        return $stmt->execute();
    }
    
    function deletarContato($id){
        $sql = "UPDATE tbl_contato SET excluido_em = NOW() WHERE id_contato = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

function buscarContatoPorId($db, $id){
    $sql = 'SELECT id_contato, nome_contato, email_contato FROM tbl_contato WHERE id_contato = :id';
    $statment = $db->prepare($sql);
    $statment->bindParam(':$id', $id); 
    return $statment->execute();
}
 
// $ok = RegistraUsuario($db, 'João Silva', 'joaosilva@kkkkk.com', '123456');
// echo $ok;
// var_dump($resultado);
//$ok = registrarUsuario($db, 'Hevellin', 'hevellin.9@xxx.com', '121212');
//echo $ok;

//$resultado = buscaUsuarios($db);
//var_dump($resultado);
