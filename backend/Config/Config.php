<?php

namespace App\Misu\Database;

class Config
{
    public static function get()
    {
        return [
            'database' => array (
  'driver' => 'mysql',
  'mysql' => 
  array (
    'host' => 'localhost',
    'db_name' => 'misu',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'port' => 3306,
  ),
)
        ];
    }
}
