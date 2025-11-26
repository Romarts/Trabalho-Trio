<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* --- ESTILO PERSONALIZADO (Cores do Cadastro aplicadas ao Login) --- */
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 1); /* Sombra mais escura igual cadastro */
            overflow: hidden;
            animation: fadeInUp 0.8s ease-out;
            background-color: white;
        }

        /* CABEÇALHO: Preto com borda Verde Neon */
        .login-header {
            background: #000000ff; 
            color: white;
            padding: 2rem 1rem;
            text-align: center;
            border-bottom: 5px solid #00ff4cff; 
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
        }

        .form-control {
            border-left: none;
            padding: 12px;
        }

        /* FOCO: Brilho e Borda Verde */
        .form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
        }
        
        .input-group:focus-within {
            box-shadow: 0 0 0 0.25rem rgba(0, 245, 33, 0.65); /* Sombra Verde */
            border-radius: 0.375rem;
        }
        .input-group:focus-within .input-group-text, 
        .input-group:focus-within .form-control {
            border-color: #1adb00ff; /* Borda Verde */
        }

        /* BOTÃO: Preto que fica Verde ao passar o mouse */
        .btn-login {
            padding: 12px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: transform 0.2s;
            background-color: #000000ff; /* Preto */
            border: none;
            color: white;
        }

        .btn-login:hover {
            background-color: #00be19ff; /* Verde Hover */
            transform: scale(1.02);
            color: white;
        }

        /* Link de cadastro com a cor verde */
        .link-destaque {
            color: #00be19ff;
            text-decoration: none;
            font-weight: bold;
        }
        .link-destaque:hover {
            color: #00ff4cff;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translate3d(0, 40px, 0); }
            to { opacity: 1; transform: translate3d(0, 0, 0); }
        }
    </style>
</head>

<div class="login-wrapper">
    <div class="col-12 col-md-8 col-lg-5 col-xl-4">
        
        <div class="card login-card">
            
            <div class="login-header">
                <i class="bi bi-person-circle fs-1 mb-2"></i> 
                <h4 class="mb-0 fw-bold">Bem-vindo de volta!</h4>
                <small class="text-white-50">Acesse sua conta para continuar</small>
            </div>

            <div class="card-body p-4 p-md-5">
                
                <?php if (isset($erro)): ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div><?php echo $erro; ?></div>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['msg']) && $_GET['msg'] == 'sucesso'): ?>
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div>Cadastro realizado! Faça login.</div>
                    </div>
                <?php endif; ?>

                <form action="?page=login" method="POST">
                    
                    <div class="mb-4">
                        <label for="email" class="form-label text-muted fw-bold small">E-MAIL</label>
                        <div class="input-group">
                            <span class="input-group-text text-muted"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" name="email" id="email" class="form-control" required placeholder="seu@email.com">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="senha" class="form-label text-muted fw-bold small">SENHA</label>
                        <div class="input-group">
                            <span class="input-group-text text-muted"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" name="senha" id="senha" class="form-control" required placeholder="Sua senha">
                            <button class="btn btn-outline-secondary border-start-0" type="button" onclick="mostrarSenha()" style="border-color: #ced4da;">
                                <i id="iconeSenha" class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="text-end mt-1">
                            <a href="#" class="text-decoration-none small text-muted">Esqueceu a senha?</a>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-login shadow-sm">
                            ACESSAR CONTA
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="card-footer text-center py-3 bg-light border-0">
                <small class="text-muted">Não tem conta <a href="?page=cadastrar" class="link-destaque">Cadastre-se agora</a></small>
            </div>
        </div>
        
    </div>
</div>

<script>
    function mostrarSenha() {
        var inputPass = document.getElementById('senha');
        var btnIcon = document.getElementById('iconeSenha');

        if (inputPass.type === "password") {
            inputPass.type = "text";
            btnIcon.classList.remove('bi-eye');
            btnIcon.classList.add('bi-eye-slash');
        } else {
            inputPass.type = "password";
            btnIcon.classList.remove('bi-eye-slash');
            btnIcon.classList.add('bi-eye');
        }
    }
</script>
