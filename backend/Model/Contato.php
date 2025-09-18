<?php
include_once 'backend/Database/Database.php';
include_once 'backend/Model/Contato.php';

function buscaContato($db){
    $sql = 'SELECT id_contato, nome_contato, email_contato FROM tbl_contato ';
    $statment = $db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $statment->execute();
    return $resultado = $statment->fetchAll();

}

function buscarContatoPorId($db, $id){
    $sql = 'SELECT id_contato, nome_contato, email_contato FROM tbl_contato WHERE id_contato = :id';
    $statment = $db->prepare($sql);
    $statment->bindParam(':$id', $id); 
    return $statment->execute();
}

function registrarContato($db, $nome, $email){
    $sql = 'INSERT INTO tbl_contato (nome_contato, email_contato) 
    VALUES (:nome, :email)';
    $statment = $db->prepare($sql);
    $statment->bindParam(':nome', $nome); 
    $statment->bindParam(':email', $email);
    return $statment->execute();
}
