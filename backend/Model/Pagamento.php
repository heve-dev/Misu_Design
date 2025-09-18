<?php
// função é um bloco { } de código que pode ser reutilizado várias vezes
// uma função pode receber parâmetros ( ) e retornar um valor 
// e ele fica esperando ser chamado para ser executado
// function nomeDaFuncao($parametro1, $parametro2){ ... return ... }
//dentro da função não enxergamos variaveis globais

/* Executa uma instrução preparada passando um array de valores */
class Pagamento{
    private $id_pagamento;
    private $id_cliente;
    private $total_devedor;
    private $data_pagamento;
    private $status_pagamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    //construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }
 
/* Executa uma instrução preparada passando um array de valores */
function BuscaPagamento($db){
   
    $sql = 'SELECT nome_usuario, email_usuario FROM tbl_usuario';
    $statment = $db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $statment->execute();
    return $resultado = $statment->fetchAll();
 
}
function BuscaPagamentoPorData($db,$email){
    $sql = 'SELECT nome_usuario, email_usuario FROM tbl_usuario WHERE email_usuario = :email';
    $statment = $db->prepare($sql);
    $statment->bindParam(':email', $email);
    $statment->execute();
    return $resultado = $statment->fetchAll();
   
}
function RegistraPagamento($db, $nome, $email, $senha){
    $sql = 'INSERT INTO tbl_usuario (nome_usuario, email_usuario, senha_usuario)
    VALUES (:nome, :email, :senha)';
    $statment = $db->prepare($sql);
    $statment->bindParam(':nome', $nome);
    $statment->bindParam(':email', $email);
    $statment->bindParam(':status', $status);
    if($statment->execute()){
        return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
function atualizarPagamento($id, $nome, $email, $senha = null, $tipo = null, $status = null){
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
    function deletarPagamento($id){
        $sql = "UPDATE tbl_usuario SET excluido_em = NOW() WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
function BuscaPagamentoPorID($db,$id){
    $sql = 'SELECT nome_usuario, email_usuario FROM tbl_usuario WHERE id_usuario = :id';
    $statment = $db->prepare($sql);
    $statment->bindParam(':id', $id);
    return $statment->execute();
   
}
 
// $ok = RegistraUsuario($db, 'João Silva', 'joaosilva@kkkkk.com', '123456');
// echo $ok;
// var_dump($resultado);
//$ok = registrarUsuario($db, 'Hevellin', 'hevellin.9@xxx.com', '121212');
//echo $ok;

//$resultado = buscaUsuarios($db);
//var_dump($resultado);