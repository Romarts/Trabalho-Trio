<?php
// app/controllers/AdminController.php
require_once '../app/models/Produto.php';

class AdminController {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // Verifica se é ADMIN. Se não for, manda pra home.
        if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'admin') {
            header('Location: index.php');
            exit;
        }
    }

    // Lista os produtos na tabela
    public function index() {
        $produtoModel = new Produto();
        $stmt = $produtoModel->lerTodos();
        include '../app/views/site/admin_lista.php';
    }

    // Mostra o formulário (Serve para Novo e Editar)
    public function form() {
        $produto = null;
        if (isset($_GET['id'])) {
            $produtoModel = new Produto();
            $produto = $produtoModel->lerUm($_GET['id']);
        }
        include '../app/views/site/admin_form.php';
    }

    // Recebe os dados do formulário e salva
    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produtoModel = new Produto();
            
            // Pega os dados do POST
            $id = $_POST['id'];
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $preco = $_POST['preco'];
            $estoque = $_POST['estoque'];

            if ($id) {
                // Se tem ID, é edição
                $produtoModel->atualizar($id, $nome, $descricao, $preco, $estoque);
            } else {
                // Se não tem, é novo
                $produtoModel->criar($nome, $descricao, $preco, $estoque);
            }
            header('Location: ?page=admin-produtos&msg=salvo');
        }
    }

    // Apaga o produto
    public function excluir() {
        if (isset($_GET['id'])) {
            $produtoModel = new Produto();
            $produtoModel->excluir($_GET['id']);
        }
        header('Location: ?page=admin-produtos&msg=deletado');
    }
}
?>