<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* --- ANIMAÇÕES E ESTILOS (Paleta Black & Neon Green) --- */

    /* Entrada suave */
    .fade-in {
        animation: fadeIn 0.8s ease-in-out;
    }

    /* O Card do Produto */
    .product-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        background: #fff;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    /* Hover do Card: Levanta e Sombra Neon sutil */
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 190, 25, 0.15); /* Sombra levemente esverdeada */
    }

    /* Container da imagem */
    .img-container {
        height: 220px;
        overflow: hidden;
        position: relative;
        background-color: #f8f9fa;
    }

    .img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .product-card:hover .img-container img {
        transform: scale(1.1);
    }

    /* Tipografia */
    .product-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #000; /* Título Preto */
        margin-bottom: 0.5rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-price {
        color: #00be19; /* O Verde do seu Login */
        font-weight: 800;
        font-size: 1.4rem;
    }

    .section-icon {
        color: #00be19; /* Ícone do título em verde */
    }

    /* BOTÃO PERSONALIZADO (Estilo Login) */
    .btn-add-cart {
        background-color: #000000; /* Preto Puro */
        border: none;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        padding: 10px 20px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    /* Hover: Vira o Verde do Login */
    .btn-add-cart:hover {
        background-color: #00be19; 
        transform: scale(1.02);
        box-shadow: 0 6px 12px rgba(0, 190, 25, 0.4); /* Brilho verde */
        color: white;
    }

    .btn-add-cart:active {
        transform: scale(0.95);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container fade-in">
    <div class="row mb-4 align-items-center">
        <div class="col-12 text-center text-md-start">
            <h2 class="fw-bold mb-0 text-dark">
                <i class="bi bi-shop me-2 section-icon"></i>Nossos Produtos
            </h2>
            <p class="text-muted">Confira as melhores opções para você.</p>
        </div>
    </div>
    
    <div class="row g-4">
        <?php while ($row = $stmt->fetch_assoc()): 
             $img = !empty($row['imagem']) ? $row['imagem'] : 'https://dummyimage.com/300x200/dee2e6/6c757d.jpg';
        ?>
            <div class="col-sm-6 col-lg-4 col-xl-3">
                
                <div class="card h-100 product-card">
                    <div class="img-container">
                        <img src="<?php echo $row['url_imagem']; ?>" class="card-img-top" alt="<?php echo $row['nome']; ?>" style="height: 200px; object-fit: cover;">
                        </div>

                    <div class="card-body d-flex flex-column">
                        <h5 class="product-title" title="<?php echo htmlspecialchars($row['nome']); ?>">
                            <?php echo $row['nome']; ?>
                        </h5>
                        
                        <p class="card-text text-muted small flex-grow-1">
                            <?php 
                                echo strlen($row['descricao']) > 60 ? substr($row['descricao'], 0, 60) . '...' : $row['descricao']; 
                            ?>
                        </p>
                        
                        <div class="mt-3">
                            <h4 class="product-price mb-3">
                                R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?>
                            </h4>
                            
                            <a href="?page=carrinho&add=<?php echo $row['id']; ?>" class="btn btn-add-cart w-100 text-decoration-none">
                                <i class="bi bi-cart-plus-fill"></i> Adicionar
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        <?php endwhile; ?>
    </div>
</div>