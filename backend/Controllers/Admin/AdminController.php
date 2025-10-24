<?php

namespace App\Misu\Controllers\Admin;

use App\Misu\Core\Flash;
use App\Misu\Core\Redirect;

abstract class AdminController extends AuthenticatedController{
    public function __construct() {
        parent::__construct();
        if($this->session->get('usuario_tipo') !== 'admin'){
            Redirect::redirecionarComMensagem(
                'admin/dashboard',
                'error',
                'Você não tem permissão para acessar essa página.'
            );
        }
    }
}