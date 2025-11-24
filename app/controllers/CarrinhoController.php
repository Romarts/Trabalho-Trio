<?php
require_once '../app/models/Produto.php';

class CarrinhoController {

    public function __construct() {
        // Garante que a sessão esteja iniciada para manipular $_SESSION
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Adicionar item ao carrinho
    public function adicionar($id) {
        // Inicializa o carrinho se não existir
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        // Se o produto já existe, incrementa a quantidade
        if (isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id]['qtd']++;
        } else {
            // Se não existe, busca no banco e adiciona
            $produtoModel = new Produto();
            $produto = $produtoModel->lerUm($id);

            if ($produto) {
                $_SESSION['carrinho'][$id] = [
                    'id'    => $produto['id'],
                    'nome'  => $produto['nome'],
                    'preco' => $produto['preco'],
                    'qtd'   => 1
                ];
            }
        }

        // Redireciona de volta para o carrinho
        header('Location: ?page=carrinho');
        exit;
    }

    // Listar os itens do carrinho (View)
    public function listar() {
        include '../app/views/site/carrinho.php';
    }

    // Finalizar a compra (com verificação de login)
    public function finalizar() {
        // 1. Validação de Segurança: O usuário está logado?
        // (Substitua 'usuario_id' pela chave que você usa no seu LoginController)
        if (!isset($_SESSION['usuario_id'])) {
            // Salva para onde ele queria ir
            $_SESSION['redirect_after_login'] = '?page=finalizar';
            
            // Manda para o login
            header('Location: ?page=login');
            exit;
        }

        // 2. Validação Lógica: O carrinho tem itens?
        if (empty($_SESSION['carrinho'])) {
            header('Location: ?page=carrinho&msg=vazio');
            exit;
        }

        // --- AQUI ENTRARIA A LÓGICA DE SALVAR NO BANCO DE DADOS ---
        // Ex: $pedidoModel->criarPedido($_SESSION['usuario_id'], $_SESSION['carrinho']);
        // ----------------------------------------------------------

        // 3. Sucesso: Limpa o carrinho
        unset($_SESSION['carrinho']);

        // Limpa a variável de redirecionamento se ela ainda existir
        if (isset($_SESSION['redirect_after_login'])) {
            unset($_SESSION['redirect_after_login']);
        }

        // Redireciona com mensagem de sucesso
        header('Location: ?page=carrinho&msg=sucesso');
        exit;
    }
}
?>