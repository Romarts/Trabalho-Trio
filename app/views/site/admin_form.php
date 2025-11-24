<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4><?php echo $produto ? 'Editar Produto' : 'Cadastrar Produto'; ?></h4>
        </div>
        <div class="card-body">
            <form action="?page=admin-salvar" method="POST">
                <input type="hidden" name="id" value="<?php echo $produto['id'] ?? ''; ?>">
                
                <div class="mb-3">
                    <label>Nome do Produto</label>
                    <input type="text" name="nome" class="form-control" required value="<?php echo $produto['nome'] ?? ''; ?>">
                </div>
                
                <div class="mb-3">
                    <label>Descrição</label>
                    <textarea name="descricao" class="form-control"><?php echo $produto['descricao'] ?? ''; ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Preço (R$)</label>
                        <input type="number" step="0.01" name="preco" class="form-control" required value="<?php echo $produto['preco'] ?? ''; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Estoque (Qtd)</label>
                        <input type="number" name="estoque" class="form-control" required value="<?php echo $produto['estoque'] ?? ''; ?>">
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100">Salvar</button>
                <a href="?page=admin-produtos" class="btn btn-secondary w-100 mt-2">Cancelar</a>
            </form>
        </div>
    </div>
</div>