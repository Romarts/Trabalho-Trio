<style>
    /* Tema Arte & Madeira */
    :root {
        --cor-madeira: #A0522D;
        --fundo-escuro: #2c2a29;
    }
    
    .payment-card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        overflow: hidden;
        background: white;
    }
    
    .payment-header {
        background-color: var(--fundo-escuro);
        color: white;
        padding: 20px;
        border-bottom: 4px solid var(--cor-madeira);
    }

    .option-box {
        border: 2px solid #eee;
        border-radius: 8px;
        padding: 15px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
    }

    /* Quando o radio está marcado, a borda fica marrom */
    .form-check-input:checked + .option-content {
        color: var(--cor-madeira);
        font-weight: bold;
    }
    
    .option-box:hover {
        border-color: #ddd;
        background-color: #fcfcfc;
    }

    .btn-confirmar {
        background-color: var(--cor-madeira);
        color: white;
        font-weight: bold;
        padding: 12px;
        border: none;
        border-radius: 5px;
        width: 100%;
        font-size: 1.1rem;
        transition: 0.3s;
    }

    .btn-confirmar:hover {
        background-color: #8B4513;
        color: white;
        box-shadow: 0 4px 10px rgba(139, 69, 19, 0.3);
    }

    .qr-container {
        background: #fdfbf7;
        border: 2px dashed #d1c4b9;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
    }
</style>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <div class="card payment-card">
                <div class="payment-header">
                    <h4 class="mb-0" style="font-family: 'Georgia', serif;">
                        <i class="bi bi-wallet2 me-2"></i> Finalizar Pagamento
                    </h4>
                </div>
                
                <div class="card-body p-4">
                    <!-- O formulário envia para a rota que FINALIZA de verdade o pedido -->
                    <form action="?page=finalizar" method="POST" id="formPagamento">
                        
                        <h5 class="mb-4 text-muted">Escolha a forma de pagamento:</h5>

                        <!-- OPÇÃO 1: PIX -->
                        <div class="mb-3">
                            <label class="option-box w-100">
                                <input class="form-check-input me-3" type="radio" name="metodo_pagamento" id="radioPix" value="pix" checked onclick="togglePagamento('pix')">
                                <div class="option-content">
                                    <i class="bi bi-qr-code-scan me-2 fs-5"></i> PIX (Aprovação Imediata)
                                </div>
                            </label>
                        </div>

                        <!-- CONTEÚDO PIX (QR CODE) -->
                        <div id="areaPix" class="mb-4">
                            <div class="qr-container">
                                <small class="text-muted d-block mb-3">Escaneie o QR Code ou use a chave abaixo:</small>
                                
                                <!-- QR Code estático gerado para teste -->
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=12117824927" class="img-fluid mb-3" alt="QR Code PIX">
                                
                                <div class="input-group">
                                    <input type="text" class="form-control text-center bg-white" value="12117824927" readonly id="chavePix">
                                    <button class="btn btn-outline-secondary" type="button" onclick="copiarPix()">
                                        <i class="bi bi-files"></i> Copiar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- OPÇÃO 2: CARTÃO -->
                        <div class="mb-3">
                            <label class="option-box w-100">
                                <input class="form-check-input me-3" type="radio" name="metodo_pagamento" id="radioCartao" value="cartao" onclick="togglePagamento('cartao')">
                                <div class="option-content">
                                    <i class="bi bi-credit-card me-2 fs-5"></i> Cartão de Crédito
                                </div>
                            </label>
                        </div>

                        <!-- CONTEÚDO CARTÃO -->
                        <div id="areaCartao" class="mb-4" style="display: none;">
                            <div class="p-3 bg-light rounded border">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">NÚMERO DO CARTÃO</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-credit-card-2-front"></i></span>
                                        <input type="text" name="cartao_numero" class="form-control" placeholder="0000 0000 0000 0000" maxlength="19" id="inputCartao">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-muted">VALIDADE</label>
                                        <input type="text" name="cartao_validade" class="form-control" placeholder="MM/AA" maxlength="5">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-muted">CVV</label>
                                        <input type="text" name="cartao_cvv" class="form-control" placeholder="123" maxlength="3" id="inputCVV">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        
                        <!-- Resumo rápido do total -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="text-muted">Total a pagar:</span>
                            <?php 
                                $total = 0;
                                // Calcula o total pegando da sessão do carrinho
                                if(isset($_SESSION['carrinho'])) {
                                    foreach($_SESSION['carrinho'] as $item) {
                                        $total += ($item['preco'] * $item['qtd']);
                                    }
                                }
                            ?>
                            <h3 class="fw-bold" style="color: var(--cor-madeira);">
                                R$ <?php echo number_format($total, 2, ',', '.'); ?>
                            </h3>
                        </div>

                        <button type="submit" class="btn btn-confirmar shadow">
                            <i class="bi bi-check-circle-fill me-2"></i> Confirmar Pedido
                        </button>
                        
                        <div class="text-center mt-3">
                            <a href="?page=carrinho" class="text-muted text-decoration-none small">
                                <i class="bi bi-arrow-left"></i> Voltar ao carrinho
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Função para trocar entre PIX e Cartão
    function togglePagamento(tipo) {
        var areaPix = document.getElementById('areaPix');
        var areaCartao = document.getElementById('areaCartao');
        var inputCartao = document.getElementById('inputCartao');
        var inputCVV = document.getElementById('inputCVV');

        if (tipo === 'pix') {
            areaPix.style.display = 'block';
            areaCartao.style.display = 'none';
            // Remove obrigatoriedade do cartão
            inputCartao.required = false;
            inputCVV.required = false;
        } else {
            areaPix.style.display = 'none';
            areaCartao.style.display = 'block';
            // Torna cartão obrigatório
            inputCartao.required = true;
            inputCVV.required = true;
        }
    }

    // Função para copiar a chave PIX
    function copiarPix() {
        var copyText = document.getElementById("chavePix");
        copyText.select();
        copyText.setSelectionRange(0, 99999); 
        navigator.clipboard.writeText(copyText.value);
        alert("Chave PIX copiada!");
    }
</script>