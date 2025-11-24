<div class="row">
    <div class="col-12 mb-4">
        <h2>Nossos Produtos</h2>
    </div>
    
    <?php while ($row = $stmt->fetch_assoc()): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="https://dummyimage.com/300x200/dee2e6/6c757d.jpg" class="card-img-top" alt="Produto">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['nome']; ?></h5>
                    <p class="card-text text-muted"><?php echo $row['descricao']; ?></p>
                    <h4 class="text-success">R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></h4>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <a href="?page=carrinho&add=<?php echo $row['id']; ?>" class="btn btn-primary w-100">
                        Adicionar ao Carrinho
                    </a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>