<?php

namespace App\Misu\Rotas;

class Rotas
{

 public static function get()
    {
        return [
            "GET" => [
//Usuario        o caminho da URL     o nome do controle e o metodo do controle
                "/usuario" => "UsuarioController@index",
                "/usuario/criar" => "UsuarioController@viewCriarUsuarios",
                "/usuario/listar/{pagina}" => "UsuarioController@viewListarUsuarios",
                "/usuario/editar/{id}" => "UsuarioController@viewEditarUsuarios",
                "/usuario/excluir/{id}" => "UsuarioController@viewExcluirUsuarios",
//Servico
                "/servico" => "ServicosController@index",
                "/servico/criar" => "ServicoController@viewCriarServicos",
                "/servico/listar" => "ServicoController@viewListarServicos",
                "/servico/editar/{id}" => "ServicoController@viewEditarServicos",
                "/servico/excluir/{id}" => "ServicoController@viewExcluirServicos",
//Contato
                "/contato" => "ContatoController@index",
                "/contato/criar" => "ContatoController@viewCriarContato",
                "/contato/listar" => "ContatoController@viewListarContato",
                "/contato/editar{id}" => "ContatoController@viewEditarContato",
                "/contato/excluir{id}" => "ContatoController@viewExcluirContato",
//Avaliacao
                "/avaliacao" => "AvaliacaoController@index",
                "/avaliacao/criar" => "AvaliacaoController@viewCriarAvaliacao",
                "/avaliacao/listar" => "AvaliacaoController@viewListarAvaliacao",
                "/avaliacao/editar{id}" => "AvaliacaoController@viewEditarAvaliacao",
                "/avaliacao/excluir{id}" => "AvaliacaoController@viewExcluirAvaliacao",
//Pagamento
                "/pagamento" => "PagamentoController@index",
                "/pagamento/criar" => "PagamentoController@viewCriarPagamento",
                "/pagamento/listar" => "PagamentoController@viewListarPagamento",
                "/pagamento/editar{id}" => "PagamentoController@viewEditarPagamento",
                "/pagamento/excluir{id}" => "PagamentoController@viewExcluirPagamento",
//Orcamento
                "/orcamento" => "OrcamentoController@index",
                "/orcamento/criar" => "OrcamentoController@viewCriarOrcamento",
                "/orcamento/listar" => "OrcamentoController@viewListarOrcamento",
                "/orcamento/editar{id}" => "OrcamentoController@viewEditarOrcamento",
                "/orcamento/excluir{id}" => "OrcamentoController@viewExcluirOrcamento",

                // Relatórios

                "/usuario/{id}/relatorio/{dataInicial}/{dataFinal}" => "UsuarioController@relatorioIsuario",

                // Dashboard
                '/register' => 'AuthController@register',
                '/login' => 'AuthController@login',
                '/logout' => 'AuthController@logout',
                '/admin/dashboard' => 'Admin\DashboardController@index',


    ],
    
    // POST POST POST POST

                "POST" => [
                "/usuario/salvar/{id}" => "UsuarioController@salvarUsuario",
                "/usuario/atualizar/{id}" => "UsuarioController@atualizarUsuario",
                "/usuario/deletar/{id}" => "UsuarioController@deletarUsuario",
                
                '/register' => 'AuthController@cadastrarUsuario',
                '/login' => 'AuthController@authenticar',


//Servico
                "/servico/salvar" => "ServicoController@salvarServicos",
                "/servico/atualizar/{id}" => "ServicoController@atualizarServicos",
                "/servico/deletar" => "ServicoController@deletarServicos",
                
//Contato
                "/contato/salvar" => "ContatoController@salvarContato",
                "/contato/atualizar" => "ContatoController@atualizarContato",
                "/contato/deletar" => "ContatoController@deletarContato",
//Avaliacao
                "/avaliacao/salvar" => "AvaliacaoController@salvarAvaliacao",
                "/avaliacao/atualizar" => "AvaliacaoController@atualizarAvaliacao",
                "/avaliacao/deletar" => "AvaliacaoController@deletarAvaliacao",
//Pagamento
                "/pagamento/salvar" => "PagamentoController@salvarPagamento",
                "/pagamento/atualizar" => "PagamentoController@atualizarPagamento",
                "/pagamento/deletar" => "PagamentoController@deletarPagamento",
//Orcamento
                "/orcamento/salvar" => "OrcamentoController@salvarOrcamento",
                "/orcamento/atualizar" => "OrcamentoController@atualizarOrcamento",
                "/orcamento/deletar" => "OrcamentoController@deletarOrcamento",

                ]
        ];
    }
}
