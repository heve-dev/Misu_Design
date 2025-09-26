<?php

namespace App\Misu;

require_once __DIR__.'/../vendor/autoload.php'; //o autoload carrega todas as classes do composer

use App\Misu\Controllers\UsuarioController ;

//23/09
// var_dump($_SERVER["REQUEST_URI"]);
// echo "\n\n\n\n";
// var_dump($_REQUEST["REQUEST_METHOD"]);
// exit;
if(($_SERVER["REQUEST_URI"]) =="/backend/buscarUsuario" && $_SERVER["REQUEST_METHOD"] == "GET")
{
$controller = new UsuarioController();
$resultado = $controller->index();
var_dump($resultado);
}else{
    echo "rota não encontrada";
}
// 26/09

$usuarioController = new UsuarioController();
$caminho = $_SERVER["REQUEST_URI"] ?? '/';
$metodo =  $_SERVER["REQUEST_METHOD"] ?? 'GET';

if($caminho === '/src/api' && $metodo === 'GET'){
    echo "Bem-vindo API";

}else if(strtolower ($caminho) === '/src/usuarios' && $metodo === 'GET'){
    $usuarioController->listar();
}


$usuarioController-> converterEmArray();


