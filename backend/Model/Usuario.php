<?php

namespace App\Misu\Model;

use PDO;

class Usuario{
    public $id_usuario;
    public $nome_usuario;
    public $email_usuario;
    public $tipo_usuario;
    public $senha_usuario;
    public $status_usuario;
    public $criado_em;
    public $atualizado_em;
    public $excluido_em;
}

    public function buscarTodosUsuarios(){
    //array associativo - chave a valor / esta dentro de um array posicional
    return [
        ['id_usuario' => 1, 'nome_usuario' => 'João Silva', 'email_usuario'],
        ['id_usuario' => 2, 'nome_usuario' => 'Maria Souza', 'email_usuario']
    ];
   }

   public function buscarUmaPessoa(){
    //array posicional - cada posição é acessada por posição
    return ['heve' => 1, 'nome_usuario' => 'João Silva', 'email_usuario'];
    
   }

   public function buscarTexto(){
    return "o gato roeu a roupa do rei de roma";
   }




require_once __DIR__.'/../Config/Database.php';
require_once __DIR__.'/../Model/usuario.php';
require_once __DIR__.'/../Model/Config.php';

$usuario = new Usuario($db);
// função é um bloco { } de código que pode ser reutilizado várias vezes
// uma função pode receber parâmetros ( ) e retornar um valor 
// e ele fica esperando ser chamado para ser executado
// function nomeDaFuncao($parametro1, $parametro2){ ... return ... }
//dentro da função não enxergamos variaveis globais

/* Executa uma instrução preparada passando um array de valores */
class Usuario{
    private $id_usuario;
    private $nome_usuario;
    private $email_usuario;
    private $tipo_usuario;
    private $senha_usuario;
    private $status_usuario;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    //construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }
 
/* Executa uma instrução preparada passando um array de valores */
function buscarUsuario($db){
   
    $sql = 'SELECT nome_usuario, email_usuario FROM tbl_usuario';
    $statment = $db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $statment->execute();
    return $resultado = $statment->fetchAll();
 
}
function buscarUsuarioPorEmail($db,$email){
    $sql = 'SELECT nome_usuario, email_usuario FROM tbl_usuario WHERE email_usuario = :email';
    $statment = $db->prepare($sql);
    $statment->bindParam(':email', $email);
    $statment->execute();
    return $resultado = $statment->fetchAll();
   
}
function registrarUsuario($db, $nome, $email, $senha){
    $sql = 'INSERT INTO tbl_usuario (nome_usuario, email_usuario, senha_usuario)
    VALUES (:nome, :email, :senha)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha',password_hash( $senha, PASSWORD_bCRYPT));
    $stmt->bindParam(':tipo', $tipo_usuario);
    $stmt->bindParam(':status', $status_usuario);
    if($stmt->execute()){
        return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
function atualizarUsuario($id, $nome, $email, $senha = null, $tipo = null, $status = null){
        $sql = "UPDATE tbl_usuario SET nome_usuario = :nome, email_usuario = :email";
        if($senha){
            $sql .= ", senha_usuario = :senha";
        }
        if($tipo){
            $sql .= ", tipo_usuario = :tipo";
        }
        if($status){
            $sql .= ", status_usuario = :status";
        }
        $sql .= ", atualizado_em = NOW() WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        if($senha){
            $stmt->bindParam(':senha', password_hash($senha, PASSWORD_BCRYPT));
        }
        if($tipo){
            $stmt->bindParam(':tipo', $tipo);
        }
        if($status){
            $stmt->bindParam(':status', $status);
        }
        return $stmt->execute();
    }
    function deletarUsuario($id){
        $sql = "UPDATE tbl_usuario SET excluido_em = NOW() WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
function buscarUsuariosPorId($db,$id){
    $sql = 'SELECT nome_usuario, email_usuario FROM tbl_usuario WHERE id_usuario = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
   
}

//19/09
 
//metodo de inativar o usuario delete
function inativarUsuario($id){
    $dataatual = date('Y-m-d H:i:s');
    $sql = "UPDATE tbl_usuario SET excluido_em = :atual WHERE id_usuario = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if ($stmt->execute()){
    return true;
    } else {
        return false;
    };
}

//metodo de ativar o usuario excluido read
function ativarUsuario($id){
    $sql = "UPDATE tbl_usuario SET excluido_em = :atual WHERE id_usuario = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if ($stmt->execute()){
        return true;
    } else {
        return false;
    };
}
// metodo de buscar todos os usuarios
function buscarTodosUsuarios(){
    $sql = "SELECT * FROM tbl_usuario WHERE excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// usuarios inativos
function buscarTodosUsuariosInativos(){
    $sql = "SELECT * FROM tbl_usuario WHERE excluido_em IS NOT NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
//metodo de buscar usuario por email read
function buscarUsuarioPorEmail($email){
    $sql = "SELECT * FROM tbl_usuario WHERE email_usuario = :email AND excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
// emails inativos read
function buscarUsuarioPorEmailInativo($email){
    $sql = "SELECT * FROM tbl_usuario WHERE email_usuario = :email AND excluido_em IS NOT NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

























// $ok = RegistraUsuario($db, 'João Silva', 'joaosilva@kkkkk.com', '123456');
// echo $ok;
// var_dump($resultado);
//$ok = registrarUsuario($db, 'Hevellin', 'hevellin.9@xxx.com', '121212');
//echo $ok;

//$resultado = buscaUsuarios($db);
//var_dump($resultado);