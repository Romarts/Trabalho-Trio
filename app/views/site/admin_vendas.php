<div class="container mt-5">
    <h2>Relatório de Vendas</h2>
    <div class="mb-3"><a href="?page=home" class="btn btn-secondary">Voltar</a></div>

    <table class="table table-bordered table-striped bg-white">
        <thead class="table-dark">
            <tr>
                <th>ID Pedido</th>
                <th>Cliente</th>
                <th>Data</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td>#<?php echo $row['id']; ?></td>
                <td><?php echo $row['nome_cliente']; ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($row['data_pedido'])); ?></td>
                <td class="text-success fw-bold">R$ <?php echo number_format($row['total'], 2, ',', '.'); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>