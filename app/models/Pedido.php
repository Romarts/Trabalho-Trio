<?php
// CORREÇÃO AQUI: Adicionei mais um "../" para achar a pasta config correta
require_once __DIR__ . '/../../config/database.php';

class Pedido {
    private $conn;
    private $table_name = "pedidos";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function salvar($id_usuario, $total) {
        $query = "INSERT INTO " . $this->table_name . " (id_usuario, total) VALUES (:id_usuario, :total)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_usuario", $id_usuario);
        $stmt->bindParam(":total", $total);
        return $stmt->execute();
    }

    public function lerTodas() {
        $query = "SELECT p.id, p.total, p.data_pedido, u.nome as nome_cliente 
                  FROM " . $this->table_name . " p
                  JOIN usuarios u ON p.id_usuario = u.id
                  ORDER BY p.data_pedido DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>