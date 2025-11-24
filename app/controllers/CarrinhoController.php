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
        // ... (seu código de finalizar continua aqui) ...
        if (!isset($_SESSION['usuario_id'])) {
            $_SESSION['redirect_after_login'] = '?page=finalizar';
            header('Location: ?page=login');
            exit;
        }
        if (empty($_SESSION['carrinho'])) {
            header('Location: ?page=carrinho&msg=vazio');
            exit;
        }
        unset($_SESSION['carrinho']);
        if (isset($_SESSION['redirect_after_login'])) unset($_SESSION['redirect_after_login']);
        header('Location: ?page=carrinho&msg=sucesso');
        exit;
    }
}
?>