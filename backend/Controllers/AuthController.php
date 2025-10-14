<?php
namespace App\Misu\Controllers;

use App\Misu\Model\Usuario;
use App\Misu\Database\Database;
use App\Misu\Core\View;
use App\Misu\Core\Redirect;
use App\Misu\Validadores\UsuarioValidador;
use App\Misu\Core\FileManager;
use App\Misu\Core\Flash;
use App\Misu\Core\Session;

class AuthController {
    private Usuario $usuarioModel;
    private Session $session ;

    public function __construct() {
        $db = Database::getInstance();
        $this->usuarioModel = new Usuario($db);
        $this->session = new Session();
    }
    public function login(): void{
        View::render('auth/login');
    }
    public function register(): void{
        View::render('auth/register');
    }
    public function logout(): void{
        $this->session->destroy();
        Redirect::redirecionarComMensagem('login', 'success', 'Logout realizado com sucesso!');
    }
    public function autenticar(): void{
        $email = $_POST['email_usuario'] ?? null;
        $senha = $_POST['senha_usuario'] ?? null;

        $usuario = $this->usuarioModel->checarCredenciais($email, $senha);

        if($usuario){
           session_regenerate_id(true);
           $this->session->set('usuario_id', $usuario['id_usuario']);
              $this->session->set('usuario_nome', $usuario['nome_usuario']);
              $this->session->set('usuario_tipo', $usuario['tipo_usuario']);
              Redirect::redirecionarPara('/admin/dashboard');
        } else {
            Redirect::redirecionarComMensagem('/backend/login', 'erros', 'E-mail ou senha incorretos. :( Tente novamente.');
        }
    }

    public function cadastrarUsuario(): void{
$erros = UsuarioValidador::validarEntradas($_POST);
if(!empty($erros)){
    Redirect::redirecionarComMensagem('/register', 'erros', implode("<br>", $erros));
 }
        $nome = $_POST['nome_usuario'] ?? null;
        $email = $_POST['email_usuario'] ?? null;
        $senha = $_POST['senha_usuario'] ?? null;
        $senha_confirm = $_POST['senha_confirm'] ?? null;
        
        if($senha !=$senha_confirm){
            Redirect::redirecionarComMensagem('/register', 'erros', 'As senhas não coincidem. Tente novamente.');
            return;
        }

        if(!empty($this->usuarioModel->buscarUsuariosPorEmail($email))){
            Redirect::redirecionarComMensagem('/register', 'erros', 'Erro ao cadastrar, problema com seu e-mail. Tente outro.');
        }

        $novoUsuarioId = $this->usuarioModel->registrarUsuarios($nome, $email, $senha, 'usuario', 'Ativo', 'null');
        if($novoUsuarioId){
            Redirect::redirecionarComMensagem('/login', 'success', 'Cadastro realizado com sucesso! Faça login para continuar.');
        } else {
            Redirect::redirecionarComMensagem('/register', 'error', 'Erro no servidor. Tente novamente.');
        }
}
}