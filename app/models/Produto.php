<?php
require_once __DIR__ . '/../../config/database.php';

class Produto {
    private $conn;
    private $table_name = "produtos";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function criar($nome, $descricao, $preco, $estoque) {
        $query = "INSERT INTO " . $this->table_name . " (nome, descricao, preco, estoque) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        
        // "ssdi" = String, String, Double (decimal), Integer
        $stmt->bind_param("ssdi", $nome, $descricao, $preco, $estoque);
        return $stmt->execute();
    }

    public function lerTodos() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $result = $this->conn->query($query);
        return $result; // Retorna o objeto de resultado direto
    }

    public function lerUm($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function atualizar($id, $nome, $descricao, $preco, $estoque) {
        $query = "UPDATE " . $this->table_name . " SET nome=?, descricao=?, preco=?, estoque=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssdii", $nome, $descricao, $preco, $estoque, $id);
        return $stmt->execute();
    }

    public function excluir($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function baixarEstoque($id, $qtd_vendida) {
        $query = "UPDATE " . $this->table_name . " SET estoque = estoque - ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $qtd_vendida, $id);
        return $stmt->execute();
    }

    public function contarEstoqueTotal() {
        $query = "SELECT SUM(estoque) as total FROM " . $this->table_name;
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }
}
?>