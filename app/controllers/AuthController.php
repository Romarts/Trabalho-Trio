<?php
require_once '../app/models/Usuario.php';

class AuthController {
    
    public function login() {
        // 1. Garante que a sessão está ativa para podermos ler e gravar nela
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            
            $userModel = new Usuario();
            $usuario = $userModel->login($email, $senha);
            
            if ($usuario) {
                // Salva os dados do banco na sessão
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_tipo'] = $usuario['tipo']; // Importante para o painel Admin!

                // 2. LÓGICA DO REDIRECIONAMENTO (A novidade)
                // Verifica se existe algum lugar pendente para ir (ex: finalizar compra)
                if (isset($_SESSION['redirect_after_login'])) {
                    $destino = $_SESSION['redirect_after_login'];
                    unset($_SESSION['redirect_after_login']); // Limpa para não usar de novo
                    header("Location: $destino");
                } else {
                    // Se não tiver pendência, vai para a Home normal
                    header("Location: index.php");
                }
                exit; // Sempre use exit após header location

            } else {
                $erro = "Email ou senha inválidos!";
                include '../app/views/site/login.php';
            }
        } else {
            include '../app/views/site/login.php';
        }
    }

public function cadastrar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            
            $userModel = new Usuario();
            
            // Tenta cadastrar
            if ($userModel->cadastrar($nome, $email, $senha)) {
                // SUCESSO: Redireciona para login
                header("Location: ?page=login&msg=sucesso");
                exit;
            } else {
                // FALHA: E-mail já existe
                $erro = "Este e-mail já está cadastrado! Tente outro.";
                // Carrega a tela de cadastro novamente mostrando o erro
                include '../app/views/site/cadastro.php';
            }
        } else {
            // Se não for POST, só mostra o formulário
            include '../app/views/site/cadastro.php';
        }
    }
    
    public function logout() {
        // Garante que a sessão existe antes de destruir
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header("Location: ?page=login");
        exit;
    }
}
?>