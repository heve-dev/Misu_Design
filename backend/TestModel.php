<?php

include_once __DIR__.'backend/Database/Database.php';
include_once __DIR__.'backend/Model/Usuario.php';

$hevellin = new Usuario($db);
// $resultado = $hevellin->buscaUsuarios();
$resultado = $hevellin->buscaUsuarioPorEmail('nomedoemail');
var_dump($resultado);