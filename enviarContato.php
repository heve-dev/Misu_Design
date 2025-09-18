<?php
include_once 'backend/Database/Database.php';
include_once 'backend/Model/Contato.php';

//operação ternaria
$nome = $_POST["nome"] ?? '';
$email = $_POST["email"] ?? '';

$ok = registrarContato($db, $nome, $email);
if($ok > 0 || $ok === true){
    echo "Contato registrado com sucesso!";
}else{
    echo "Erro ao registrar contato";
}