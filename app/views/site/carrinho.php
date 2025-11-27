<style>
    /* CSS para deixar o carrinho elegante */
    .cart-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .cart-header {
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
    }
    .img-carrinho {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
    .btn-qty {
        width: 30px;
        height: 30px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    .total-summary {
        background: #fdfdfd;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 20px;
    }
</style>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-bag"></i> Carrinho de Compras</h2>
        <span class="badge bg-secondary rounded-pill"><?php echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0; ?> itens</span>
    </div>

    <!-- Mensagens do Sistema -->
    <?php if (isset($_GET['msg'])): ?>
        <?php if ($_GET['msg'] == 'sucesso'): ?>
            <div class="alert alert-success text-center shadow-sm">
                <h4>🎉 Pedido Realizado!</h4>
                <p class="mb-0">Obrigado pela compra. Seu estoque já foi atualizado.</p>
            </div>
        <?php elseif ($_GET['msg'] == 'vazio'): ?>
            <div class="alert alert-warning text-center">
                Seu carrinho está vazio! Adicione itens antes de finalizar.
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (empty($_SESSION['carrinho'])): ?>
        <div class="text-center py-5">
            <h3 class="text-muted">Seu carrinho está vazio 😢</h3>
            <a href="?page=produtos" class="btn btn-primary mt-3">Ver Produtos</a>
        </div>
    <?php else: ?>
        <div class="row">
            <!-- Coluna da Tabela -->
            <div class="col-lg-8">
                <div class="cart-card mb-4">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="cart-header text-muted">
                            <tr>
                                <th class="ps-4">Produto</th>
                                <th class="text-center">Qtd</th>
                                <th class="text-end">Preço</th>
                                <th class="text-end pe-4">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total_geral = 0;
                            foreach ($_SESSION['carrinho'] as $id => $item): 
                                $subtotal = $item['preco'] * $item['qtd'];
                                $total_geral += $subtotal;
                                // Pega a imagem ou usa uma padrão se não tiver
                                $img = !empty($item['imagem']) ? $item['imagem'] : 'https://dummyimage.com/80x80/dee2e6/6c757d.jpg';
                            ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo $img; ?>" class="img-carrinho me-3" alt="Foto">
                                        <div>
                                            <h6 class="mb-0 fw-bold"><?php echo $item['nome']; ?></h6>
                                            <small class="text-muted">Ref: <?php echo $item['id']; ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <!-- Formulário para alterar quantidade -->
                                    <form action="?page=atualizar_carrinho" method="POST" class="d-flex justify-content-center align-items-center gap-2">
                                        <!-- Truque para chamar a rota certa, já que não estamos usando Roteador complexo -->
                                        <!-- No seu index.php você precisaria adicionar case 'atualizar_carrinho' apontando para $carrinho->atualizar() -->
                                        <!-- OU simplificamos usando o próprio input change se preferir, mas aqui vai com botões -->
                                        
                                        <!-- Visual apenas, a lógica real precisaria de um ajuste na rota se quiser botões + e - -->
                                        <div class="input-group input-group-sm" style="width: 100px;">
                                            <input type="number" name="qtd" value="<?php echo $item['qtd']; ?>" class="form-control text-center" min="1">
                                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                                            <button type="submit" class="btn btn-outline-secondary" title="Atualizar"><i class="bi bi-arrow-clockwise"></i></button>
                                        </div>
                                    </form>
                                </td>
                                <td class="text-end fw-bold">
                                    R$ <?php echo number_format($subtotal, 2, ',', '.'); ?>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="?page=remover_item&id=<?php echo $id; ?>" class="btn btn-sm btn-outline-danger" title="Remover item">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Coluna do Resumo -->
            <div class="col-lg-4">
                <div class="total-summary shadow-sm">
                    <h4 class="mb-3">Resumo do Pedido</h4>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <strong>R$ <?php echo number_format($total_geral, 2, ',', '.'); ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="text-muted">Frete</span>
                        <span class="text-success">Grátis</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="h5">Total</span>
                        <span class="h4 text-primary fw-bold">R$ <?php echo number_format($total_geral, 2, ',', '.'); ?></span>
                    </div>
                    
                    <a href="?page=finalizar" class="btn btn-success w-100 btn-lg mb-2 shadow">
                        Finalizar Compra
                    </a>
                    <a href="?page=produtos" class="btn btn-outline-secondary w-100">
                        Continuar Comprando
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>