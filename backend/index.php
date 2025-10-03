<?php

namespace App\Misu;

require_once __DIR__.'/../vendor/autoload.php'; //o autoload carrega todas as classes do composer

if (!isset($_SESSION)) {
            session_start();
        }

use App\Misu\Rotas\Rotas;

$rotas = Rotas::get();

// rotas estara mapeando a classe e o metodo
$metodoHttp = $_SERVER["REQUEST_METHOD"];
$rota = $_SERVER["REQUEST_URI"];
if(array_key_exists($rota, $rotas[$metodoHttp]) == false ){
    http_response_code(404);
    echo "Página não foi encontrada :(";
    exit;
}
//     retorno string para separar em partes
$partes = explode("@", $rotas[$metodoHttp][$rota] );
$nomeController = $partes[0];
$metodoController = $partes[1];
$nomeCompletoController = "App\\Misu\\Controllers\\". $nomeController;
if(!class_exists($nomeCompletoController)){
    http_response_code(500);
    echo "O controlador não foi encontrado :(";
    exit;
}
$controller = new $nomeCompletoController();
$controller->$metodoController();




// var_dump ($partes);

//23/09
// var_dump($_SERVER["REQUEST_URI"]);
// echo "\n\n\n\n";
// var_dump($_REQUEST["REQUEST_METHOD"]);
// exit;
// if(($_SERVER["REQUEST_URI"]) =="/backend/buscarUsuario" && $_SERVER["REQUEST_METHOD"] == "GET")
// {
//     $controller = new UsuarioController();
//     $resultado = $controller->index();
//     var_dump($resultado);
// }else{
//     echo "rota não encontrada";
// }

// // 26/09

// $usuarioController = new UsuarioController();
// $caminho = $_SERVER["REQUEST_URI"] ?? '/';
// $metodo =  $_SERVER["REQUEST_METHOD"] ?? 'GET';

// if($caminho === '/src/api' && $metodo === 'GET'){
//     echo "Bem-vindo API";

// }else if(strtolower ($caminho) === '/src/usuarios' && $metodo === 'GET'){
//     $usuarioController->listar();
// }


// $usuarioController-> converterEmArray();


