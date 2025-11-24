<?php
require_once __DIR__ . '/../../config/database.php';

class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function cadastrar($nome, $email, $senha) {
        // Verifica duplicidade (Nome OU Email)
        $checkQuery = "SELECT id FROM " . $this->table_name . " WHERE email = ? OR nome = ?";
        $stmtCheck = $this->conn->prepare($checkQuery);
        $stmtCheck->bind_param("ss", $email, $nome);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            return false;
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $query = "INSERT INTO " . $this->table_name . " (nome, email, senha, tipo) VALUES (?, ?, ?, 'cliente')";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $nome, $email, $senhaHash);
        return $stmt->execute();
    }

    public function login($email, $senha) {
        $query = "SELECT id, nome, senha, tipo FROM " . $this->table_name . " WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if(password_verify($senha, $row['senha'])) { 
                return $row;
            }
        }
        return false;
    }

    public function lerClientes() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE tipo = 'cliente' ORDER BY id DESC";
        return $this->conn->query($query);
    }

    public function excluir($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function contarClientes() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE tipo = 'cliente'";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}
?>