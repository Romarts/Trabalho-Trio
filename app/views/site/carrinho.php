<div class="container mt-4">
    <h2>Meu Carrinho de Compras</h2>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'sucesso'): ?>
        <div class="alert alert-success">Compra finalizada com sucesso! Obrigado.</div>
    <?php endif; ?>
    
    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'vazio'): ?>
        <div class="alert alert-warning">Seu carrinho está vazio, adicione itens antes de finalizar.</div>
    <?php endif; ?>

    <?php if (empty($_SESSION['carrinho'])): ?>
        <div class="alert alert-warning">Seu carrinho está vazio. <a href="?page=produtos">Ir às compras!</a></div>
    <?php else: ?>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Produto</th>
                    <th>Preço Unitário</th>
                    <th>Qtd</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total_geral = 0;
                foreach ($_SESSION['carrinho'] as $id => $item): 
                    $subtotal = $item['preco'] * $item['qtd'];
                    $total_geral += $subtotal;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['nome']); ?></td>
                    <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                    <td><?php echo $item['qtd']; ?></td>
                    <td>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><strong>TOTAL:</strong></td>
                    <td><strong>R$ <?php echo number_format($total_geral, 2, ',', '.'); ?></strong></td>
                </tr>
            </tfoot>
        </table>

        <div class="d-flex justify-content-between mb-5">
            <a href="?page=produtos" class="btn btn-secondary">Continuar Comprando</a>

            <a href="?page=finalizar" class="btn btn-success btn-lg">Finalizar Compra</a>
        </div>

    <?php endif; ?>
</div>