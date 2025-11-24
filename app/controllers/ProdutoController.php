<?php
require_once '../app/models/Produto.php';

class ProdutoController {
    
    public function listar() {
        $produtoModel = new Produto();
        $stmt = $produtoModel->lerTodos();
        
        // Carrega a visualização (View)
        include '../app/views/site/lista_produtos.php';
    }
    
    // Aqui depois faremos a função de adicionar ao carrinho
}
?>