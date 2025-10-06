<?php

namespace App\Misu\Model;

use PDO;

class ItemAgendamento{
    private $id_item_agendamento;
    private $id_agendamento;
    private $id_servico;
    private $id_cliente;
    private $valor_servico;
    private $quantidade_solicitada;
    private $descricao_item_agendamento;
    private $total_item;
    private $status_item_agendamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
 // contrutor inicializa a classe e ou atributos
  public function __construct($db){
        $this->db = $db;
    }

}