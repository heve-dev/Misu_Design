<?php
namespace App\Misu\Core;
use App\Misu\Core\EmailService;

class NotificationService{
    private EmailService $emailService;
    public function __construct(){
        $this->emailService = new EmailService();
    }
    public function enviarEmailDeBoasVindas(array $userData): bool {
        $nome = htmlspecialchars($userData['nome_usuario']);
        $email = $userData['email_usuario'];

        $assunto = "Bem-vindo(a) à Plataforma Misu!";
        $mensagem = "<h1>Olá, {$nome}!</h1>";
        $mensagem .= "<p>Seu cadastro em nossa plataforma foi realizado com sucesso.</p>";
        $mensagem .= "<p>Agora você já pode fazer o login e aproveitar todos os recursos.</p>";
        $mensagem .= "<p>Atenciosamente,<br>Equipe Misu</p>";
        return $this->emailService->send($email, $assunto, $mensagem);
    }

    public function enviarEmailDeEqueciASenha(array $userData, string $token): bool {
        $email = $userData['email_usuario'];
        $resetLink = 'http://' . $_SERVER['HTTP_HOST'] . '/backend/reseta-senha/' . $token;

        $assunto = "Redefinição de Senha - Misu";
        $mensagem = "<p>Olá,</p>";
        $mensagem .= "<p>Solicitação para redefinir sua senha. clique no link abaixo:</p>";
        $mensagem .= "<a href='{$resetLink}'>Redefinir Minha Senha</a>";
        $mensagem .= "<p>Se você não solicitou isso, pode ignorar este e-mail com segurança.</p>";
        return $this->emailService->send($email, $assunto, $mensagem);
    }
}