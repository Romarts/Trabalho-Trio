<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* --- TEMA RÚSTICO --- */
    
    :root {
        --cor-madeira: #A0522D;
        --cor-madeira-hover: #8B4513;
    }

    .fade-in { animation: fadeIn 0.8s ease-in-out; }

    .product-card {
        border: 1px solid #eee; /* Borda sutil */
        border-radius: 8px; /* Cantos menos redondos */
        overflow: hidden;
        background: #fff;
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(139, 69, 19, 0.15); /* Sombra marrom suave */
        border-color: var(--cor-madeira);
    }

    .img-container {
        height: 220px;
        overflow: hidden;
        position: relative;
        background-color: #fcfcfc;
    }

    .img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .product-card:hover .img-container img { transform: scale(1.08); }

    .product-title {
        font-family: 'Georgia', serif;
        font-size: 1.15rem;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .product-price {
        color: var(--cor-madeira);
        font-weight: 700;
        font-size: 1.3rem;
    }

    .section-icon { color: var(--cor-madeira); }

    /* Botão Rústico */
    .btn-add-cart {
        background-color: var(--cor-madeira);
        border: none;
        border-radius: 4px;
        color: white;
        font-weight: 500;
        padding: 10px 20px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-add-cart:hover {
        background-color: var(--cor-madeira-hover);
        color: white;
        box-shadow: 0 4px 8px rgba(139, 69, 19, 0.3);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container fade-in">
    <div class="row mb-5 align-items-center">
        <div class="col-12 text-center">
            <h2 class="fw-bold mb-2 text-dark" style="font-family: 'Georgia', serif;">
                Nossa Coleção
            </h2>
            <div style="width: 60px; height: 3px; background: #A0522D; margin: 0 auto;"></div>
            <p class="text-muted mt-3">Móveis artesanais e decoração rústica para seu lar.</p>
        </div>
    </div>
    
    <div class="row g-4">
        <?php while ($row = $stmt->fetch_assoc()): 
             $img = !empty($row['imagem']) ? $row['imagem'] : 'https://dummyimage.com/300x200/dee2e6/6c757d.jpg';
        ?>
            <div class="col-sm-6 col-lg-4 col-xl-3">
                <div class="card h-100 product-card">
                    <div class="img-container">
                        <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($row['nome']); ?>">
                    </div>

                    <div class="card-body d-flex flex-column text-center">
                        <h5 class="product-title" title="<?php echo htmlspecialchars($row['nome']); ?>">
                            <?php echo $row['nome']; ?>
                        </h5>
                        
                        <p class="card-text text-muted small flex-grow-1">
                            <?php echo strlen($row['descricao']) > 60 ? substr($row['descricao'], 0, 60) . '...' : $row['descricao']; ?>
                        </p>
                        
                        <div class="mt-3">
                            <h4 class="product-price mb-3">
                                R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?>
                            </h4>
                            
                            <a href="?page=carrinho&add=<?php echo $row['id']; ?>" class="btn btn-add-cart w-100 text-decoration-none">
                                <i class="bi bi-bag-plus"></i> Adicionar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>