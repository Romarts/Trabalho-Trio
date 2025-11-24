<?php
require_once __DIR__ . '/../../config/database.php';

class Pedido {
    private $conn;
    private $table_name = "pedidos";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function salvar($id_usuario, $total) {
        $query = "INSERT INTO " . $this->table_name . " (id_usuario, total) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("id", $id_usuario, $total); // int, double
        return $stmt->execute();
    }

    public function lerTodas() {
        $query = "SELECT p.id, p.total, p.data_pedido, u.nome as nome_cliente 
                  FROM " . $this->table_name . " p
                  JOIN usuarios u ON p.id_usuario = u.id
                  ORDER BY p.data_pedido DESC";
        return $this->conn->query($query);
    }

    public function faturamentoHoje() {
        $query = "SELECT SUM(total) as total FROM " . $this->table_name . " WHERE DATE(data_pedido) = CURDATE()";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }
}
?>