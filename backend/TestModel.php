<?php

include_once __DIR__.'Database/Database.php';
include_once __DIR__.'Model/usuario.php';

$hevellin = new Usuario($db);
// $resultado = $hevellin->buscaUsuarios();
$resultado = $hevellin->buscaUsuarioPorEmail('nomedoemail');
var_dump($resultado);