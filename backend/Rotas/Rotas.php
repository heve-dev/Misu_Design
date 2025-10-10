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
                "/usuario/criar" => "UsuarioController@viewCriarUsuario",
                "/usuario/listar/{pagina}" => "UsuarioController@viewListarUsuario",
                "/usuario/editar/{id}" => "UsuarioController@viewEditarUsuario",
                "/usuario/excluir/{id}" => "UsuarioController@viewExcluirUsuario",
//PerfilPerfilUsuario  
                "/perfilUsuario" => "PerfilUsuarioController@index",
                "/perfilUsuario/criar" => "PerfilUsuarioController@viewCriarPerfilUsuario",
                "/perfilUsuario/listar" => "PerfilUsuarioController@viewListarPerfilUsuario",
                "/perfilUsuario/editar/{id}" => "PerfilUsuarioController@viewEditarPerfilUsuario",
                "/perfilUsuario/excluir/{id}" => "PerfilUsuarioController@viewExcluirPerfilUsuario",
//Servico
                "/servicos" => "ServicosController@index",
                "/servico/criar" => "ServicosController@viewCriarServicos",
                "/servico/listar" => "ServicosController@viewListarServicos",
                "/servico/editar/{id}" => "ServicosController@viewEditarServicos",
                "/servico/excluir/{id}" => "ServicosController@viewExcluirServicos",
//Categoria
                "/categoria" => "CategoriaController@index",
                "/categoria/criar" => "CategoriaController@viewCriarCategoria",
                "/categoria/listar" => "CategoriaController@viewListarCategoria",
                "/categoria/editar/{id}" => "CategoriaController@viewEditarCategoria",
                "/categoria/excluir/{id}" => "CategoriaController@viewExcluirCategoria",
//Agendamento
                "/agendamento" => "AgendamentoController@index",
                "/agendamento/criar" => "AgendamentoController@viewCriarAgendamento",
                "/agendamento/listar" => "AgendamentoController@viewListarAgendamento",
                "/agendamento/editar{id}" => "AgendamentoController@viewEditarAgendamento",
                "/agendamento/excluir{id}" => "AgendamentoController@viewExcluirAgendamento",
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
//ItemOrcamento
                "/itemOrcamento" => "ItemOrcamentoController@index",
                "/itemOrcamento/criar" => "ItemOrcamentoController@viewCriarItemOrcamento",
                "/itemOrcamento/listar" => "ItemOrcamentoController@viewListarItemOrcamento",
                "/itemOrcamento/editar{id}" => "ItemOrcamentoController@viewEditarItemOrcamento",
                "/itemOrcamento/excluir{id}" => "ItemOrcamentoController@viewExcluirItemOrcamento",
//ItemAgendamento
                "/itemAgendamento" => "ItemAgendamentoController@index",
                "/itemAgendamento/criar" => "ItemAgendamentoController@viewCriarItemAgendamento",
                "/itemAgendamento/listar" => "ItemAgendamentoController@viewListarItemAgendamento",
                "/itemAgendamento/editar/{id}" => "ItemAgendamentoController@viewEditarItemAgendamento",
                "/itemAgendamento/excluir/{id}" => "ItemAgendamentoController@viewExcluirItemAgendamento",

                // Relatórios

                "/usuario/{id}/relatorio/{dataInicial}/{dataFinal}" => "UsuarioController@relatorioIsuario",


    ],
    
    // POST POST POST POST

                "POST" => [
                "/usuario/salvar/{id}" => "UsuarioController@salvarUsuario",
                "/usuario/atualizar/{id}" => "UsuarioController@atualizarUsuario",
                "/usuario/deletar/{id}" => "UsuarioController@deletarUsuario",
//PerfilPerfilUsuario  
                "/perfilUsuario/salvar/{id}" => "PerfilUsuarioController@salvarPerfilUsuario",
                "/perfilUsuario/atualizar/{id}" => "PerfilUsuarioController@atualizarPerfilUsuario",
                "/perfilUsuario/deletar" => "PerfilUsuarioController@deletarPerfilUsuario",

//Servico
                "/servico/salvar/{id}" => "ServicoController@salvarServico",
                "/servico/atualizar/{id}" => "ServicoController@atualizarServico",
                "/servico/deletar" => "ServicoController@deletarServico",
                
//Categoria
                "/categoria/salvar/{id}" => "CategoriaController@salvarCategoria",
                "/categoria/atualizar/{id}" => "CategoriaController@atualizarCategoria",
                "/categoria/deletar" => "CategoriaController@deletarCategoria",
//Agendamento
                "/agendamento/salvar" => "AgendamentoController@salvarAgendamento",
                "/agendamento/atualizar" => "AgendamentoController@atualizarAgendamento",
                "/agendamento/deletar" => "AgendamentoController@deletarAgendamento",
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
//ItemOrcamento
                "/itemOrcamento/salvar" => "ItemOrcamentoController@salvarItemOrcamento",
                "/itemOrcamento/atualizar" => "ItemOrcamentoController@atualizarItemOrcamento",
                "/itemOrcamento/deletar" => "ItemOrcamentoController@deletarItemOrcamento",
//ItemAgendamento
                "/itemAgendamento/salvar" => "ItemAgendamentoController@salvarItemAgendamento",
                "/itemAgendamento/atualizar" => "ItemAgendamentoController@atualIzaritemAgendamento",
                "/itemAgendamento/deletar" => "ItemAgendamentoController@deletarItemAgendamento",

                ]
        ];
    }
}
