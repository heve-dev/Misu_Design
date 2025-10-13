<?php
namespace App\Misu;
require_once __DIR__.'/../vendor/autoload.php';

use Bramus\Router\Router;
$router = new Router();
$router->setNamespace('App\Misu\Controllers');
//   puxa o GET e POST do rotas.php 
use App\Misu\Rotas\Rotas;//rota=URL
$rotas = Rotas::get();

foreach ($rotas as $metodoHttp => $rota) {
    foreach ($rota as $uri => $acao) {
        $metodoBramus = strtolower($metodoHttp);
       
        $router->{$metodoBramus}($uri, $acao); // a mágica acontece aqui
    }
}

$router->set404(function() {
    header($_SERVER['SERVER_PROTOCOL'] . '404 Not Found');
    echo '404, Rota não encontrada :( ';
});

$router->run();



