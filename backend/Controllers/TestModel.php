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


$id = $usuario->inserirPerfilsuario('Hevellin', 'aaaa@gmail.com','123456','cliente','ativo');
$resultado + $perfil_usuario->inserirPerfil(
    $id, 'foto', 'banner','descrição');
//$resultado = $endereco->excluirPerfil(1);
if ($resultado) {
    echo "Perfil inserido com sucesso!";
} else {
    echo "Erro ao inserir Perfil.";
}