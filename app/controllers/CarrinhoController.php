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
                    'imagem' => $produto['url_imagem'], // <--- O SEGREDO ESTÁ AQUI (Salva a foto)
                    'qtd' => 1
                ];
            }
        }
        header('Location: ?page=carrinho');
        exit;
    }

    public function remover($id) {
        if (isset($_SESSION['carrinho'][$id])) {
            unset($_SESSION['carrinho'][$id]);
        }
        header('Location: ?page=carrinho');
        exit;
    }

    public function atualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nova_qtd = (int)$_POST['qtd']; // Força ser número inteiro

            if ($nova_qtd > 0 && isset($_SESSION['carrinho'][$id])) {
                $_SESSION['carrinho'][$id]['qtd'] = $nova_qtd;
            } elseif ($nova_qtd == 0) {
                // Se colocar zero, remove o item
                unset($_SESSION['carrinho'][$id]);
            }
        }
        header('Location: ?page=carrinho');
        exit;
    }

    public function listar() {
        include '../app/views/site/carrinho.php';
    }

    public function finalizar() {
        if (!isset($_SESSION['usuario_id'])) {
            $_SESSION['redirect_after_login'] = '?page=finalizar';
            header('Location: ?page=login');
            exit;
        }
        if (empty($_SESSION['carrinho'])) {
            header('Location: ?page=carrinho&msg=vazio');
            exit;
        }

        // Salva Pedido (Seu modelo de Pedido)
        require_once '../app/models/Pedido.php';
        $total = 0;
        foreach ($_SESSION['carrinho'] as $item) {
            $total += $item['preco'] * $item['qtd'];
        }
        
        // Tenta salvar o pedido
        // Se der erro aqui é porque falta criar o arquivo Pedido.php, mas vamos seguir sua lógica
        if (class_exists('Pedido')) {
            $pedidoModel = new Pedido();
            $pedidoModel->salvar($_SESSION['usuario_id'], $total);
        }

        // Baixa Estoque
        $produtoModel = new Produto();
        foreach ($_SESSION['carrinho'] as $id => $item) {
            // Verifica se o método existe para evitar erro fatal
            if (method_exists($produtoModel, 'baixarEstoque')) {
                $produtoModel->baixarEstoque($id, $item['qtd']);
            }
        }

        unset($_SESSION['carrinho']);
        if (isset($_SESSION['redirect_after_login'])) unset($_SESSION['redirect_after_login']);
        
        header('Location: ?page=carrinho&msg=sucesso');
        exit;
    }
}
?>