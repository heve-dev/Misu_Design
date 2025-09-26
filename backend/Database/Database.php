<?php
//documentação php
//https://www.php.net/manual/pt_BR/ref.pdo-mysql.connection.php

$username = 'root';
$password = '';
$host = 'localhost';
$dbname = 'misu';

try {
        $db = new \PDO('mysql:host=localhost;dbname='.$dbname.';charset=utf8mb4', $username, $password, array(

        \PDO::ATTR_EMULATE_PREPARES => false,

        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION

        ));

}catch (\PDOException $e) {
    throw new \PDOException($e->getMessage());
}

//instalar composer