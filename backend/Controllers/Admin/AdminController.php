<?php

namespace App\Misu\Controllers\Admin;

use App\Misu\Core\Redirect;

abstract class AdminController extends AuthenticatedController{
    public function __construct() {
        parent
    }
}