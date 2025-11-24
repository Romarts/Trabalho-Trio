<?php
require_once '../app/models/Produto.php';

class CarrinhoController {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function adicionar($id) {
        // ... (seu código de adicionar continua aqui) ...
        // Vou resumir para não ocupar espaço, mantenha o que você já tem
        if (!isset($_SESSION['carrinho'])) { $_SESSION['carrinho'] = []; }
        if (isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id]['qtd']++;
        } else {
            $produtoModel = new Produto();
            $produto = $produtoModel->lerUm($id);
            if ($produto) {
                $_SESSION['carrinho'][$id] = [
                    'id' => $produto['id'], 'nome' => $produto['nome'], 
                    'preco' => $produto['preco'], 'qtd' => 1
                ];
            }
        }
        header('Location: ?page=carrinho');
        exit;
    }

    // --- NOVA FUNÇÃO PARA REMOVER ---
    public function remover($id) {
        if (isset($_SESSION['carrinho'][$id])) {
            unset($_SESSION['carrinho'][$id]); // Remove o item da sessão
        }
        // Volta para o carrinho atualizado
        header('Location: ?page=carrinho');
        exit;
    }
    // --------------------------------

    public function listar() {
        include '../app/views/site/carrinho.php';
    }

public function finalizar() {
        // 1. Verificações (Login e Carrinho Vazio)
        if (!isset($_SESSION['usuario_id'])) {
            $_SESSION['redirect_after_login'] = '?page=finalizar';
            header('Location: ?page=login');
            exit;
        }
        if (empty($_SESSION['carrinho'])) {
            header('Location: ?page=carrinho&msg=vazio');
            exit;
        }

        // 2. Salva o Pedido (Isso você já tinha feito)
        require_once '../app/models/Pedido.php';
        $total = 0;
        foreach ($_SESSION['carrinho'] as $item) {
            $total += $item['preco'] * $item['qtd'];
        }
        $pedidoModel = new Pedido();
        $pedidoModel->salvar($_SESSION['usuario_id'], $total);

        // --- PARTE NOVA: ATUALIZA O ESTOQUE ---
        // Não precisa de require_once no Produto pois já tem no topo do arquivo
        $produtoModel = new Produto();
        
        foreach ($_SESSION['carrinho'] as $id => $item) {
            // Chama a função que criamos agora
            $produtoModel->baixarEstoque($id, $item['qtd']);
        }
        // --------------------------------------

        // 3. Limpa e Redireciona
        unset($_SESSION['carrinho']);
        if (isset($_SESSION['redirect_after_login'])) unset($_SESSION['redirect_after_login']);
        
        header('Location: ?page=carrinho&msg=sucesso');
        exit;
    }

public function atualizar() {
        $id = $_POST['id'];
        $nova_qtd = $_POST['qtd'];

        // VERIFICAÇÃO EXTRA: Só atualiza se o produto realmente existir no carrinho
        if ($nova_qtd > 0 && isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id]['qtd'] = $nova_qtd;
        }

        header('Location: ?page=carrinho');
        exit;
    }

}
?>