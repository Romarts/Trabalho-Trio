<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center py-3">
                    <h4 class="mb-0">Acessar Conta</h4>
                </div>
                <div class="card-body p-4">
                    
                    <?php if (isset($erro)): ?>
                        <div class="alert alert-danger text-center">
                            <?php echo $erro; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'sucesso'): ?>
                        <div class="alert alert-success text-center">
                            Cadastro realizado! Faça login.
                        </div>
                    <?php endif; ?>

                    <form action="?page=login" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" name="email" id="email" class="form-control" required placeholder="seu@email.com">
                        </div>

                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" name="senha" id="senha" class="form-control" required placeholder="Sua senha">
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3 bg-light">
                    <small>Não tem conta? <a href="?page=cadastro" class="text-decoration-none fw-bold">Cadastre-se</a></small>
                </div>
            </div>
        </div>
    </div>
</div>