<?php

namespace App\Misu\Model;

use PDO;

/* Executa uma instrução preparada passando um array de valores */
class Categoria{
    private $id_categoria;
    private $nome_categoria;
    private $descricao_categoria;
    private $foto_categoria;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    //construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }


    
}