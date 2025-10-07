<?php

namespace App\Misu\Rotas;

class Rotas
{

 public static function get()
    {
        return [
            "GET" => [
//Usuario        o caminho da URL     o nome do controle e o metodo do controle
                "/backend/usuario" => "UsuarioController@index",
                "/backend/usuario/criar" => "UsuarioController@viewCriarUsuario",
                "/backend/usuario/listar" => "UsuarioController@viewListarUsuario",
                "/backend/usuario/editar{id}" => "UsuarioController@viewEditarUsuario",
                "/backend/usuario/excluir{id}" => "UsuarioController@viewExcluirUsuario",
//PerfilPerfilUsuario  
                "/backend/perfilUsuario" => "PerfilUsuarioController@index",
                "/backend/perfilUsuario/criar" => "PerfilUsuarioController@viewCriarPerfilUsuario",
                "/backend/perfilUsuario/listar" => "PerfilUsuarioController@viewListarPerfilUsuario",
                "/backend/perfilUsuario/editar{id}" => "PerfilUsuarioController@viewEditarPerfilUsuario",
                "/backend/perfilUsuario/excluir{id}" => "PerfilUsuarioController@viewExcluirPerfilUsuario",
//Servico
                "/backend/servicos" => "ServicosController@index",
                "/backend/servico/criar" => "ServicosController@viewCriarServicos",
                "/backend/servico/listar" => "ServicosController@viewListarServicos",
                "/backend/servico/editar{id}" => "ServicosController@viewEditarServicos",
                "/backend/servico/excluir{id}" => "ServicosController@viewExcluirServicos",
//Categoria
                "/backend/categoria" => "CategoriaController@index",
                "/backend/categoria/criar" => "CategoriaController@viewCriarCategoria",
                "/backend/categoria/listar" => "CategoriaController@viewListarCategoria",
                "/backend/categoria/editar{id}" => "CategoriaController@viewEditarCategoria",
                "/backend/categoria/excluir{id}" => "CategoriaController@viewExcluirCategoria",
//Agendamento
                "/backend/agendamento" => "AgendamentoController@index",
                "/backend/agendamento/criar" => "AgendamentoController@viewCriarAgendamento",
                "/backend/agendamento/listar" => "AgendamentoController@viewListarAgendamento",
                "/backend/agendamento/editar{id}" => "AgendamentoController@viewEditarAgendamento",
                "/backend/agendamento/excluir{id}" => "AgendamentoController@viewExcluirAgendamento",
//Contato
                "/backend/contato" => "ContatoController@index",
                "/backend/contato/criar" => "ContatoController@viewCriarContato",
                "/backend/contato/listar" => "ContatoController@viewListarContato",
                "/backend/contato/editar{id}" => "ContatoController@viewEditarContato",
                "/backend/contato/excluir{id}" => "ContatoController@viewExcluirContato",
//Avaliacao
                "/backend/avaliacao" => "AvaliacaoController@index",
                "/backend/avaliacao/criar" => "AvaliacaoController@viewCriarAvaliacao",
                "/backend/avaliacao/listar" => "AvaliacaoController@viewListarAvaliacao",
                "/backend/avaliacao/editar{id}" => "AvaliacaoController@viewEditarAvaliacao",
                "/backend/avaliacao/excluir{id}" => "AvaliacaoController@viewExcluirAvaliacao",
//Pagamento
                "/backend/pagamento" => "PagamentoController@index",
                "/backend/pagamento/criar" => "PagamentoController@viewCriarPagamento",
                "/backend/pagamento/listar" => "PagamentoController@viewListarPagamento",
                "/backend/pagamento/editar{id}" => "PagamentoController@viewEditarPagamento",
                "/backend/pagamento/excluir{id}" => "PagamentoController@viewExcluirPagamento",
//Orcamento
                "/backend/orcamento" => "OrcamentoController@index",
                "/backend/orcamento/criar" => "OrcamentoController@viewCriarOrcamento",
                "/backend/orcamento/listar" => "OrcamentoController@viewListarOrcamento",
                "/backend/orcamento/editar{id}" => "OrcamentoController@viewEditarOrcamento",
                "/backend/orcamento/excluir{id}" => "OrcamentoController@viewExcluirOrcamento",
//ItemOrcamento
                "/backend/itemOrcamento" => "ItemOrcamentoController@index",
                "/backend/itemOrcamento/criar" => "ItemOrcamentoController@viewCriarItemOrcamento",
                "/backend/itemOrcamento/listar" => "ItemOrcamentoController@viewListarItemOrcamento",
                "/backend/itemOrcamento/editar{id}" => "ItemOrcamentoController@viewEditarItemOrcamento",
                "/backend/itemOrcamento/excluir{id}" => "ItemOrcamentoController@viewExcluirItemOrcamento",
//ItemAgendamento
                "/backend/itemAgendamento" => "ItemAgendamentoController@index",
                "/backend/itemAgendamento/criar" => "ItemAgendamentoController@viewCriarItemAgendamento",
                "/backend/itemAgendamento/listar" => "ItemAgendamentoController@viewListarItemAgendamento",
                "/backend/itemAgendamento/editar{id}" => "ItemAgendamentoController@viewEditarItemAgendamento",
                "/backend/itemAgendamento/excluir{id}" => "ItemAgendamentoController@viewExcluirItemAgendamento",

                // Relatórios

                "/usuario/{id}/relatorio/{dataInicial}/{dataFinal}" => "UsuarioController@relatorioIsuario",


    ],
    
    // POST POST POST POST

                "POST" => [
                "/backend/usuario/salvar" => "UsuarioController@salvarUsuario",
                "/backend/usuario/atualizar" => "UsuarioController@atualizarUsuario",
                "/backend/usuario/deletar" => "UsuarioController@deletarUsuario",
//PerfilPerfilUsuario  
                "/backend/perfilUsuario/salvar" => "PerfilUsuarioController@salvarPerfilUsuario",
                "/backend/perfilUsuario/atualizar" => "PerfilUsuarioController@atualizarPerfilUsuario",
                "/backend/perfilUsuario/deletar" => "PerfilUsuarioController@deletarPerfilUsuario",

//Servico
                "/backend/servico/salvar" => "ServicoController@salvarServico",
                "/backend/servico/atualizar" => "ServicoController@atualizarServico",
                "/backend/servico/deletar" => "ServicoController@deletarServico",
                
//Categoria
                "/backend/categoria/salvar" => "CategoriaController@salvarCategoria",
                "/backend/categoria/atualizar" => "CategoriaController@atualizarCategoria",
                "/backend/categoria/deletar" => "CategoriaController@deletarCategoria",
//Agendamento
                "/backend/agendamento/salvar" => "AgendamentoController@salvarAgendamento",
                "/backend/agendamento/atualizar" => "AgendamentoController@atualizarAgendamento",
                "/backend/agendamento/deletar" => "AgendamentoController@deletarAgendamento",
//Contato
                "/backend/contato/salvar" => "ContatoController@salvarContato",
                "/backend/contato/atualizar" => "ContatoController@atualizarContato",
                "/backend/contato/deletar" => "ContatoController@deletarContato",
//Avaliacao
                "/backend/avaliacao/salvar" => "AvaliacaoController@salvarAvaliacao",
                "/backend/avaliacao/atualizar" => "AvaliacaoController@atualizarAvaliacao",
                "/backend/avaliacao/deletar" => "AvaliacaoController@deletarAvaliacao",
//Pagamento
                "/backend/pagamento/salvar" => "PagamentoController@salvarPagamento",
                "/backend/pagamento/atualizar" => "PagamentoController@atualizarPagamento",
                "/backend/pagamento/deletar" => "PagamentoController@deletarPagamento",
//Orcamento
                "/backend/orcamento/salvar" => "OrcamentoController@salvarOrcamento",
                "/backend/orcamento/atualizar" => "OrcamentoController@atualizarOrcamento",
                "/backend/orcamento/deletar" => "OrcamentoController@deletarOrcamento",
//ItemOrcamento
                "/backend/itemOrcamento/salvar" => "ItemOrcamentoController@salvarItemOrcamento",
                "/backend/itemOrcamento/atualizar" => "ItemOrcamentoController@atualizarItemOrcamento",
                "/backend/itemOrcamento/deletar" => "ItemOrcamentoController@deletarItemOrcamento",
//ItemAgendamento
                "/backend/itemAgendamento/salvar" => "ItemAgendamentoController@salvarItemAgendamento",
                "/backend/itemAgendamento/atualizar" => "ItemAgendamentoController@atualIzaritemAgendamento",
                "/backend/itemAgendamento/deletar" => "ItemAgendamentoController@deletarItemAgendamento",

                ]
        ];
    }
}
