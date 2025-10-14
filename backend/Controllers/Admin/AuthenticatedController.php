<?php

namespace App\Misu\Controllers\Admin;

use App\Misu\Core\Session;
use App\Misu\Core\Redirect;

abstract class AuthenticatedController{
    protected Session $session;
    public function __construct() {
        $this->session = new Session();
        if(!$this->session->has('usuario_id')){
            Redirect::redirecionarComMensagem(
                'login',
                'error',
                'Você precisa estar logado para acessar essa página.'
            );
        }
    }
}