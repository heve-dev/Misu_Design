<?php

namespace App\Misu\Model;

use PDO;

class ItemOrcamento{
    private $id_item_orcamento;
    private $id_orcamento;
    private $id_servico;
    private $id_cliente;
    private $valor_servico;
    private $quantidade_solicitada;
    private $descricao_item_orcamento;
    private $total_item_orcamento;
    private $status_item_orcamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;

 // contrutor inicializa a classe e ou atributos
  public function __construct($db){
        $this->db = $db;
    }


    
}