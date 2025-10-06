<?php

namespace App\Misu\Model;

use PDO;


$usuario = new Usuario($db);
$avaliacao = new Avaliacao($db);

/* Executa uma instrução preparada passando um array de valores */
class Avaliacao{
    private $id_avaliacao;
    private $id_cliente;
    private $id_servico;
    private $descricao_avaliacao;
    private $nota_avaliacao;
    private $status_avaliacao;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    //construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }

    
}