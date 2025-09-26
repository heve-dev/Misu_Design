<?php

namespace App\Misu;

require_once __DIR__.'/../vendor/autoload.php'; //o autoload carrega todas as classes do composer

use App\Misu\Controllers\UsuarioController ;

$usuarioController = new UsuarioController();
$caminho = $_SERVER["REQUEST_URI"] ?? '/';
$metodo =  $_SERVER["REQUEST_METHOD"] ?? 'GET';

if($caminho === '/src/api' && $metodo === 'GET'){
    echo "Bem-vindo API";

}else if(strtolower ($caminho) === '/src/usuarios' && $metodo === 'GET'){
    $usuarioController->listar();
}


$usuarioController-> converterEmArray();