<?php
// app/models/Produto.php
require_once __DIR__ . '/../../config/database.php';
class Produto {
    private $conn;
    private $table_name = "produtos";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // 1. CRIAR (Create)
    public function criar($nome, $descricao, $preco, $estoque) {
        $query = "INSERT INTO " . $this->table_name . " SET nome=:nome, descricao=:descricao, preco=:preco, estoque=:estoque";
        $stmt = $this->conn->prepare($query);
        
        // Limpeza básica
        $nome = htmlspecialchars(strip_tags($nome));
        $descricao = htmlspecialchars(strip_tags($descricao));

        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":preco", $preco);
        $stmt->bindParam(":estoque", $estoque);
        return $stmt->execute();
    }

    // 2. LER TODOS (Read)
    public function lerTodos() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // 3. LER UM SÓ (Para preencher o formulário de edição)
    public function lerUm($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 4. ATUALIZAR (Update)
    public function atualizar($id, $nome, $descricao, $preco, $estoque) {
        $query = "UPDATE " . $this->table_name . " SET nome=:n, descricao=:d, preco=:p, estoque=:e WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":n", $nome);
        $stmt->bindParam(":d", $descricao);
        $stmt->bindParam(":p", $preco);
        $stmt->bindParam(":e", $estoque);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // 5. EXCLUIR (Delete)
    public function excluir($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    public function baixarEstoque($id, $qtd_vendida) {
        // Atualiza: Estoque Atual MENOS Quantidade Vendida
        $query = "UPDATE " . $this->table_name . " SET estoque = estoque - :qtd WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":qtd", $qtd_vendida);
        $stmt->bindParam(":id", $id);
        
        return $stmt->execute();
    }
}
?>