<?php

namespace App\KiPedreiro\Rotas;

class Rotas
{

 public static function get()
    {
        return [
            "GET" => [
//o caminho da URL     o nome do controle e o metodo do controle
                "/backend/usuario" => "UsuarioController@index",
                "/backend/usuario/criar" => "UsuarioController@viewCriarUsuario",
                "/backend/usuario/listar" => "UsuarioController@viewListarUsuario",
                "/backend/usuario/editar" => "UsuarioController@viewEditarUsuario",
                "/backend/usuario/excluir" => "UsuarioController@viewExcluirUsuario",
//serviços
                "/backend/servicos" => "ServicosController@index",
                "/backend/servico/criar" => "ServicosController@viewCriarServicos",
                "/backend/usuario/listar" => "ServicosController@viewListarServicos",
                "/backend/usuario/editar" => "ServicosController@viewEditarServicos",
                "/backend/usuario/excluir" => "ServicosController@viewExcluirServicos",



    ],
                "POST" => [
                "/backend/usuario/salvar" => "UsuarioController@salvarUsuario",
                "/backend/usuario/atualizar" => "UsuarioController@atualizarUsuario",
                "/backend/usuario/deletar" => "UsuarioController@deletarUsuario",
                ]
        ];
    }
}
