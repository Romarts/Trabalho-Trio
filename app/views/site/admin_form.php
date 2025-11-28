<div class="container mt-5">
    <div class="card shadow border-0">
        
        <div class="card-header text-white" style="background-color: #2c2a29; border-bottom: 4px solid #A0522D;">
            <h4 class="mb-0" style="font-family: 'Georgia', serif;">
                <i class="bi bi-box-seam me-2"></i>
                <?php echo $produto ? 'Editar Produto' : 'Cadastrar Produto'; ?>
            </h4>
        </div>
        
        <div class="card-body p-4">
            <form action="?page=admin-salvar" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="id" value="<?php echo $produto['id'] ?? ''; ?>">
                <input type="hidden" name="imagem_antiga" value="<?php echo $produto['imagem'] ?? ''; ?>">
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted">Nome do Produto</label>
                            <input type="text" name="nome" class="form-control" required value="<?php echo $produto['nome'] ?? ''; ?>" style="border-left: 4px solid #A0522D;">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted">Descrição</label>
                            <textarea name="descricao" class="form-control" rows="4"><?php echo $produto['descricao'] ?? ''; ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted">Preço (R$)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">R$</span>
                                    <input type="number" step="0.01" name="preco" class="form-control" required value="<?php echo $produto['preco'] ?? ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted">Estoque (Qtd)</label>
                                <input type="number" name="estoque" class="form-control" required value="<?php echo $produto['estoque'] ?? ''; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 text-center">
                        <label class="form-label fw-bold text-muted mb-3">Imagem do Produto</label>
                        
                        <div class="card mb-3 d-flex align-items-center justify-content-center bg-light" style="height: 250px; border: 2px dashed #ccc; overflow: hidden;">
                            <?php 
                                // Verifica se já existe imagem, senão usa uma placeholder
                                $imgShow = !empty($produto['imagem']) ? $produto['imagem'] : 'https://dummyimage.com/300x250/dee2e6/6c757d.jpg&text=Sem+Foto';
                            ?>
                            <img id="imgPreview" src="<?php echo $imgShow; ?>" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                        </div>

                        <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/*" onchange="previewImagem(this)">
                        <small class="text-muted mt-2 d-block">Formatos: JPG, PNG (Max 2MB)</small>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="?page=admin-produtos" class="btn btn-secondary px-4">Cancelar</a>
                    <button type="submit" class="btn text-white px-5" style="background-color: #A0522D;">
                        <i class="bi bi-check-lg me-1"></i> Salvar Produto
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function previewImagem(input) {
    var preview = document.getElementById('imgPreview');
    
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>