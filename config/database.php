<?php
class Database {
    private $host = "localhost";
    private $db_name = "loja_faculdade";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // Conexão estilo MySQLi Orientado a Objetos
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            
            // Verifica erro
            if ($this->conn->connect_error) {
                die("Erro de conexão: " . $this->conn->connect_error);
            }

            // Define charset
            $this->conn->set_charset("utf8");
            
        } catch(Exception $exception) {
            echo "Erro: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>