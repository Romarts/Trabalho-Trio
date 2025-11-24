<div class="container mt-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gerenciar Clientes</h2>
        <a href="?page=admin-cliente-form" class="btn btn-success">+ Novo Cliente</a>
    </div>

    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'criado') echo "<div class='alert alert-success'>Cliente cadastrado com sucesso!</div>"; ?>
    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deletado') echo "<div class='alert alert-success'>Cliente removido!</div>"; ?>

    <div class="mb-3"><a href="?page=home" class="btn btn-secondary">Voltar para Home</a></div>

    <table class="table table-bordered bg-white">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <a href="?page=admin-excluir-cliente&id=<?php echo $row['id']; ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Tem certeza? Isso pode apagar o histórico de vendas dele.');">
                       Excluir
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>