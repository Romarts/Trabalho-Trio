<?php
class LoginController {

    public function index() {
        // Garante que a sessão existe (importante para TADS!)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Se o usuário clicou no botão "Entrar" (enviou POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            // --- SIMULAÇÃO SIMPLES (Para testar agora) ---
            // Aceita email: aluno@teste.com e senha: 123
            if ($email == 'aluno@teste.com' && $senha == '123') {
                
                // 1. Salva que o usuário está logado
                $_SESSION['usuario_id'] = 1; // ID fictício
                $_SESSION['usuario_nome'] = "Aluno TADS";

                // 2. A MÁGICA: Verifica se ele estava tentando finalizar a compra
                if (isset($_SESSION['redirect_after_login'])) {
                    $destino = $_SESSION['redirect_after_login'];
                    
                    // Limpa a memória para não ficar voltando lá sempre
                    unset($_SESSION['redirect_after_login']);
                    
                    // Manda para o carrinho/finalizar
                    header("Location: $destino");
                } else {
                    // Se for login normal, manda pra home
                    header('Location: ?page=home');
                }
                exit; // Para o código aqui

            } else {
                $erro = "Senha ou e-mail errados! Tente '123'.";
            }
        }

        // Carrega a tela de login (View)
        include '../app/views/site/login.php';
    }

    // Função para sair
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: ?page=login');
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Acessar Conta</h4>
                </div>
                <div class="card-body">
                    
                    <?php if (isset($erro)): ?>
                        <div class="alert alert-danger">
                            <?php echo $erro; ?>
                        </div>
                    <?php endif; ?>

                    <form action="?page=login" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" name="email" id="email" class="form-control" required 
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" name="senha" id="senha" class="form-control" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <small>Não tem conta? <a href="?page=cadastro">Cadastre-se</a></small>
                </div>
            </div>
        </div>
    </div>
</div>