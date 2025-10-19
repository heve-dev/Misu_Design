<?php

namespace App\Misu\Validadores;

class PedidoValidador{
    public static function ValidarEntradas($dados){
        $erros = [];
        if(isset($dados['descricao_pedido']) && empty($dados['descricao_usuario'])){
            $erros[] = "O campo é obrigatório.";
        }
        if(isset($dados['quantidade_solicitada']) &&  empty($dados['quantidade_solicitada'])){
            $erros[] = "O campo email é obrigatório.";
        } elseif(!filter_var($dados['quantidade_solicitada'] >=1 )){
            $erros[] = "O campo deve ter uma quantidade.";
        }
        if(isset($dados['total_valor_pedido']) &&   empty($dados['total_valor_pedido'])){
            $erros[] = "O campo é obrigatório.";
        } elseif(strlen($dados['total_valor_pedido']) < 1){
            $erros[] = "O campo deve ter um valor maior que 1.";
        }
        return $erros;
    }
}