<?php
// Dados de conexão
$host = 'localhost';
$usuario = 'root';
$senha = ''; // deixe vazio se não tiver senha no XAMPP
$banco = 'loja_faculdade';

// Criar conexão
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Definir charset
$conn->set_charset("utf8");
?>
