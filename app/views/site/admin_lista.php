<div class="container mt-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="bi bi-gear-fill me-2"></i> Gerenciar Produtos</h3>
        <a href="?page=admin-form" class="btn text-white" style="background-color: #A0522D;">
            <i class="bi bi-plus-lg"></i> Novo Produto
        </a>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deletado'): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert" 
             style="background-color: #d1e7dd; color: #0f5132; border-left: 5px solid #198754;">
            <i class="bi bi-check-circle-fill me-2"></i> 
            <strong>Pronto!</strong> O produto foi removido com sucesso.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="card shadow border-0">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gerenciar Produtos</h2>
        <a href="?page=admin-form" class="btn btn-success">+ Novo Produto</a>
    </div>

    <table class="table table-bordered table-striped bg-white">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td>R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></td>
                <td><?php echo $row['estoque']; ?></td>
                <td>
                    <a href="?page=admin-form&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="?page=admin-excluir&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div class="mt-3"><a href="?page=home" class="btn btn-secondary">Voltar</a></div>
</div>