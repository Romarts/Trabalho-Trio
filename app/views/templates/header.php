<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Loja Faculdade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">Loja Faculdade</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="?page=home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="?page=produtos">Produtos</a></li>
        <li class="nav-item"><a class="nav-link" href="?page=carrinho">Carrinho</a></li>
      </ul>
      <div class="d-flex">
        <?php if(isset($_SESSION['usuario_id'])): ?>
            <a href="?page=logout" class="btn btn-danger btn-sm">Sair</a>
        <?php else: ?>
            <a href="?page=login" class="btn btn-outline-light btn-sm">Login</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<div class="container">