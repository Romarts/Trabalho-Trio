<?php
require_once '../config/database.php';

class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function cadastrar($nome, $email, $senha) {
        $query = "INSERT INTO " . $this->table_name . " SET nome=:nome, email=:email, senha=:senha";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha); // senha em texto puro

        return $stmt->execute();
    }

    public function login($email, $senha) {
        $query = "SELECT id, nome, senha, tipo FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($senha === $row['senha']) { // comparação direta
                return $row;
            }
        }
        return false;
    }
}
?>
