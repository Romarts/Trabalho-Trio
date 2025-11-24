<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4>Login</h4>
                </div>
                <div class="card-body">
                    
                    <?php if (isset($erro)): ?>
                        <div class="alert alert-danger">
                            <?php echo $erro; ?>
                        </div>
                    <?php endif; ?>

                    <form action="?page=login" method="POST">
                        <div class="mb-3">
                            <label>E-mail</label>
                            <input type="email" name="email" class="form-control" value="aluno@teste.com" required>
                        </div>

                        <div class="mb-3">
                            <label>Senha</label>
                            <input type="password" name="senha" class="form-control" placeholder="Digite 123" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>