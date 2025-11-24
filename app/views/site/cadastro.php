<?php if (isset($erro)): ?>
        <div class="alert alert-danger text-center">
            <?php echo $erro; ?>
        </div>
    <?php endif;
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white">Novo Cadastro</div>
            <div class="card-body">
                <form action="?page=cadastrar" method="POST">
                    <div class="mb-3">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Senha</label>
                        <input type="password" name="senha" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Cadastrar</button>
                </form>
                <br>
                <a href="?page=login">Voltar para Login</a>
            </div>
        </div>
    </div>
</div>