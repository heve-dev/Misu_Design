<?php
namespace App\Misu\Validadores;

class ServicoValidador {
    public static function ValidarEntradas($dados) {
        $erros = [];

        if(isset($dados['nome_servico']) && empty($dados['nome_servico'])){
            $erros[] = "O campo nome do serviço é obrigatório.";
        }
        if(isset($dados['valor_servico']) && empty($dados['valor_servico'])){
            $erros[] = "O campo valor do serviço é obrigatório.";
        } elseif(!is_numeric($dados['valor_servico'])){
            $erros[] = "O campo valor do serviço deve ser um número.";
        }
        if(isset($dados['status_servico']) && empty($dados['status_servico'])){
            $erros[] = "O campo status é obrigatório.";
        }

        return $erros;
    }
}
