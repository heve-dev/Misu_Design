<?php
namespace App\Misu\Model;

use PDO;


class Contato{
    private $id_contato;
    private $nome_contato;
    private $telefone_contato;
    private $email_contato;
    private $mensagem_contato;
    private $status_contato;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
 // contrutor inicializa a classe e ou atributos
  public function __construct($db){
        $this->db = $db;
    }


    
}