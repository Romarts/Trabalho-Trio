<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* --- ESTILO PADRONIZADO (Mesmo do Login) --- */
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
            box-shadow: 0 10px 30px rgba(0, 0, 0, 1);
            overflow: hidden;
            animation: fadeInUp 0.8s ease-out;
            background-color: white;
        }
        .login-header {
            background: #000000ff;
            color: white;
            padding: 2rem 1rem;
            text-align: center;
            /* Mudei para VERDE para indicar Cadastro */
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
            border-color: #1adb00ff; /* Borda Verde ao focar */
        }
        .btn-register {
            padding: 12px;
            font-weight: bold;
            text-transform: uppercase;
            transition: transform 0.2s;
            background-color: #000000ff; /* Verde */
            border: none;
        }
        .btn-register:hover {
            background-color: #00be19ff;
            transform: scale(1.02);
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
                <i class="bi bi-person-plus-fill fs-1 mb-2"></i> <h4 class="mb-0 fw-bold">Criar Nova Conta</h4>
                <small class="text-white-50">Preencha os dados abaixo</small>
            </div>

            <div class="card-body p-4 p-md-5">
                
                <?php if (isset($erro)): ?>
                    <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                        <i class="bi bi-exclamation-octagon-fill me-2"></i>
                        <div><?php echo $erro; ?></div>
                    </div>
                <?php endif; ?>

                <form action="?page=cadastrar" method="POST">
                    
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold small">NOME COMPLETO</label>
                        <div class="input-group">
                            <span class="input-group-text text-muted"><i class="bi bi-person-fill"></i></span>
                            <input type="text" name="nome" class="form-control" required placeholder="Seu nome">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold small">E-MAIL</label>
                        <div class="input-group">
                            <span class="input-group-text text-muted"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" name="email" class="form-control" required placeholder="seu@email.com">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted fw-bold small">SENHA</label>
                        <div class="input-group">
                            <span class="input-group-text text-muted"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" name="senha" id="senhaCad" class="form-control" required placeholder="Crie uma senha forte">
                            <button class="btn btn-outline-secondary border-start-0" type="button" onclick="mostrarSenhaCad()" style="border-color: #ced4da;">
                                <i id="iconeSenhaCad" class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="form-text text-muted small mt-1">
                            A senha deve ser segura e única.
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-register shadow-sm text-white">
                            FINALIZAR CADASTRO
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="card-footer text-center py-3 bg-light border-0">
                <small class="text-muted">Já possui uma conta? <a href="?page=login" class="text-decoration-none fw-bold text-success">Fazer Login</a></small>
            </div>
        </div>
        
    </div>
</div>

<script>
    function mostrarSenhaCad() {
        var inputPass = document.getElementById('senhaCad');
        var btnIcon = document.getElementById('iconeSenhaCad');

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