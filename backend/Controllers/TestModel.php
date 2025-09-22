<?php

require_once __DIR__.'/../Config/Database.php';
require_once __DIR__.'/../Model/usuario.php';
require_once __DIR__.'/../Model/Config.php';
$usuario = new Usuario($db);


include_once __DIR__.'Database/Database.php';
include_once __DIR__.'Model/usuario.php';

$hevellin = new Usuario($db);
// $resultado = $usuario->buscaUsuarios();
//$resultado = $hevellin->buscaUsuarioPorEmail('nomedoemail');
var_dump($resultado);


$id = $usuario->inserirUsuario('Hevellin', 'aaaa@gmail.com','123456','cliente','ativo');
$resultado + $endereco->inserirEndereco(
    $id, 'rua', '123','complemento', 'bairro', 'cidade', 'estado', 'cep', 'uf'
);
//$resultado = $endereco->excluirEndereco(1);
if ($resultado) {
    echo "Endereço inserido com sucesso!";
} else {
    echo "Erro ao inserir endereço.";
}