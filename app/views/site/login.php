<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* --- ESTILO RÚSTICO (Arte & Madeira) --- */
        
        :root {
            --cor-madeira: #A0522D;      /* Marrom Sienna */
            --cor-madeira-hover: #8B4513; /* Marrom mais escuro */
            --fundo-escuro: #2c2a29;      /* Cinza Café */
        }

        body {
            /* Fundo creme suave/off-white para combinar com madeira */
            background-color: #fdfbf7; 
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
            border-radius: 8px; /* Cantos menos arredondados, mais sóbrios */
            box-shadow: 0 10px 30px rgba(60, 40, 30, 0.15); /* Sombra quente */
            overflow: hidden;
            animation: fadeInUp 0.8s ease-out;
            background-color: white;
        }

        /* CABEÇALHO: Cinza Café com borda Madeira */
        .login-header {
            background: var(--fundo-escuro); 
            color: white;
            padding: 2rem 1rem;
            text-align: center;
            border-bottom: 5px solid var(--cor-madeira); 
            font-family: 'Georgia', serif; /* Fonte elegante */
        }

        .input-group-text {
            background-color: #fcfcfc;
            border-right: none;
            color: #666;
        }

        .form-control {
            border-left: none;
            padding: 12px;
            background-color: #fcfcfc;
        }

        /* FOCO: Brilho Marrom Suave */
        .form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
        }
        
        .input-group:focus-within {
            box-shadow: 0 0 0 0.25rem rgba(160, 82, 45, 0.25); /* Sombra Marrom */
            border-radius: 0.375rem;
        }
        .input-group:focus-within .input-group-text, 
        .input-group:focus-within .form-control {
            border-color: var(--cor-madeira); /* Borda Marrom */
            color: var(--cor-madeira-hover);
        }

        /* BOTÃO: Marrom Madeira */
        .btn-login {
            padding: 12px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: transform 0.2s, background-color 0.3s;
            background-color: var(--cor-madeira);
            border: none;
            color: white;
            border-radius: 4px;
        }

        .btn-login:hover {
            background-color: var(--cor-madeira-hover);
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 4px 8px rgba(139, 69, 19, 0.3);
        }

        /* Link de cadastro com a cor madeira */
        .link-destaque {
            color: var(--cor-madeira);
            text-decoration: none;
            font-weight: bold;
        }
        .link-destaque:hover {
            color: var(--cor-madeira-hover);
            text-decoration: underline;
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
                <i class="bi bi-person fs-1 mb-2"></i> 
                <h4 class="mb-0 fw-bold">Bem-vindo</h4>
                <small class="text-white-50">Área do Cliente</small>
            </div>

            <div class="card-body p-4 p-md-5">
                
                <?php if (isset($erro)): ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert" style="background-color: #fff5f5; border-color: #fc8181; color: #c53030;">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        <div><?php echo $erro; ?></div>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['msg']) && $_GET['msg'] == 'sucesso'): ?>
                    <div class="alert alert-success d-flex align-items-center" role="alert" style="background-color: #f0fff4; border-color: #68d391; color: #276749;">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div>Cadastro realizado! Faça login.</div>
                    </div>
                <?php endif; ?>

                <form action="?page=login" method="POST">
                    
                    <div class="mb-4">
                        <label for="email" class="form-label text-muted fw-bold small">E-MAIL</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" id="email" class="form-control" required placeholder="seu@email.com">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="senha" class="form-label text-muted fw-bold small">SENHA</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="senha" id="senha" class="form-control" required placeholder="Sua senha">
                            <button class="btn btn-outline-secondary border-start-0" type="button" onclick="mostrarSenha()" style="border-color: #ced4da; background-color: #fcfcfc;">
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
                <small class="text-muted">Ainda não possui conta? <a href="?page=cadastrar" class="link-destaque">Criar cadastro</a></small>
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