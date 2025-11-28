<?php
require_once '../app/models/Produto.php';

class CarrinhoController {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function adicionar($id) {
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        if (isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id]['qtd']++;
        } else {
            $produtoModel = new Produto();
            $produto = $produtoModel->lerUm($id);

            if ($produto) {
                $_SESSION['carrinho'][$id] = [
                    'id' => $produto['id'],
                    'nome' => $produto['nome'],
                    'preco' => $produto['preco'],
                    'imagem' => $produto['imagem'] ?? null, 
                    'qtd' => 1
                ];
            }
        }
        
        // Redireciona via JavaScript para evitar erros de cabeçalho
        echo "<script>window.location.href='?page=carrinho';</script>";
        exit;
    }

    public function remover($id) {
        if (isset($_SESSION['carrinho'][$id])) {
            unset($_SESSION['carrinho'][$id]);
        }
        
        // Redireciona via JavaScript
        echo "<script>window.location.href='?page=carrinho';</script>";
        exit;
    }

    public function atualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nova_qtd = (int)$_POST['qtd']; 

            if ($nova_qtd > 0 && isset($_SESSION['carrinho'][$id])) {
                $_SESSION['carrinho'][$id]['qtd'] = $nova_qtd;
            } elseif ($nova_qtd == 0) {
                unset($_SESSION['carrinho'][$id]);
            }
        }
        
        // Redireciona via JavaScript
        echo "<script>window.location.href='?page=carrinho';</script>";
        exit;
    }

    public function listar() {
        include '../app/views/site/carrinho.php';
    }

    public function finalizar() {
        // Se não estiver logado, manda pro login
        if (!isset($_SESSION['usuario_id'])) {
            $_SESSION['redirect_after_login'] = '?page=finalizar';
            echo "<script>window.location.href='?page=login';</script>";
            exit;
        }

        // Se carrinho vazio
        if (empty($_SESSION['carrinho'])) {
            echo "<script>window.location.href='?page=carrinho&msg=vazio';</script>";
            exit;
        }

        // Salva Pedido
        require_once '../app/models/Pedido.php';
        $total = 0;
        foreach ($_SESSION['carrinho'] as $item) {
            $total += $item['preco'] * $item['qtd'];
        }
        
        if (class_exists('Pedido')) {
            $pedidoModel = new Pedido();
            if (method_exists($pedidoModel, 'salvar')) {
                $pedidoModel->salvar($_SESSION['usuario_id'], $total);
            }
        }

        // Baixa Estoque
        $produtoModel = new Produto();
        foreach ($_SESSION['carrinho'] as $id => $item) {
            if (method_exists($produtoModel, 'baixarEstoque')) {
                $produtoModel->baixarEstoque($id, $item['qtd']);
            }
        }

        // Limpa carrinho
        unset($_SESSION['carrinho']);
        if (isset($_SESSION['redirect_after_login'])) unset($_SESSION['redirect_after_login']);
        
        // Sucesso
        echo "<script>window.location.href='?page=carrinho&msg=sucesso';</script>";
        exit;
    }
}
?>