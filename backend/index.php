<?php

namespace App\Misu;

require_once __DIR__.'/../vendor/autoload.php'; //o autoload carrega todas as classes do composer

use App\Misu\Controllers\UsuarioController ;

$usuarioController = new UsuarioController();
$usuarioController-> converterEmArray();