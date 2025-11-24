<?php
// CORREÇÃO: Caminho correto do banco
require_once __DIR__ . '/../../config/database.php';

class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // --- CADASTRO E LOGIN (JÁ EXISTIAM) ---
public function cadastrar($nome, $email, $senha) {
        // 1. VERIFICAÇÃO: Checa se o e-mail já existe no banco
        $checkQuery = "SELECT id FROM " . $this->table_name . " WHERE email = :email";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bindParam(":email", $email);
        $checkStmt->execute();

        // Se encontrou alguém com esse e-mail, para tudo e retorna falso
        if ($checkStmt->rowCount() > 0) {
            return false; 
        }

        // 2. Se não existe, prossegue com o cadastro normalmente
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO " . $this->table_name . " SET nome=:nome, email=:email, senha=:senha, tipo='cliente'";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senhaHash);

        return $stmt->execute();
    }

    public function login($email, $senha) {
        $query = "SELECT id, nome, senha, tipo FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Verifica a senha hash
            if(password_verify($senha, $row['senha'])) { 
                return $row;
            }
        }
        return false;
    }

    // --- NOVO: GERENCIAMENTO DE CLIENTES (O QUE FALTAVA) ---
    
    // Lista apenas quem é cliente
    public function lerClientes() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE tipo = 'cliente' ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Exclui usuário pelo ID
    public function excluir($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>