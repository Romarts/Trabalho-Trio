<?php

class AdminController {

    private $db;

    public function __construct() {
        require_once '../app/models/Conexao.php';
        $this->db = Conexao::getInstance();

        // Verifica se está logado e é admin
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_admin'] != 1) {
            echo "<div class='alert alert-danger text-center m-4'>Acesso negado.</div>";
            exit;
        }
    }

    public function dashboard() {
        require '../app/views/admin/dashboard.php';
    }

    public function criarAdmin() {
        require '../app/views/admin/criar_admin.php';
    }

    public function salvarAdmin() {

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, email, senha, is_admin) VALUES (?, ?, ?, 1)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nome, $email, $senha]);

        echo "<div class='alert alert-success text-center m-4'>Administrador criado com sucesso!</div>";
        echo "<div class='text-center'><a class='btn btn-primary' href='?page=admin'>Voltar ao painel</a></div>";
    }
}
