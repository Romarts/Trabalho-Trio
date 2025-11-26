<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Loja Faculdade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* --- ESTILO PERSONALIZADO (Tema Black & Neon) --- */
        
        .navbar-custom {
            background-color: #000000; /* Preto absoluto */
            border-bottom: 4px solid #00ff4c; /* Borda Neon */
            padding: 0.8rem 0;
        }

        /* Marca / Logo */
        .navbar-brand {
            font-weight: bold;
            letter-spacing: 1px;
            color: white !important;
            display: flex;
            align-items: center;
        }

        /* Links do Menu */
        .nav-link {
            color: rgba(255,255,255,0.7) !important;
            font-weight: 500;
            margin-left: 10px;
            transition: all 0.3s;
        }
        .nav-link:hover, .nav-link.active {
            color: #00ff4c !important;
        }

        /* Botão de Login (Canto Direito) */
        .btn-login-nav {
            background-color: transparent;
            color: white; /* Texto Branco */
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 50px; /* Redondo */
            padding: 8px 20px;
            font-size: 0.9rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px; /* Espaço entre texto e ícone */
            transition: all 0.3s ease;
        }

        .btn-login-nav:hover {
            border-color: #00ff4c;
            color: #00ff4c;
            background-color: rgba(0, 255, 76, 0.1);
        }

        /* Avatar do Usuário (Logado) */
        .user-avatar {
            width: 35px;
            height: 35px;
            background-color: #0056b3; /* Azul parecido com o do Google/YouTube */
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
        }

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-5">
  <div class="container-fluid px-4"> 
    
    <a class="navbar-brand" href="index.php">
        <i class="bi bi-shop me-2 text-success"></i>Loja Faculdade
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="?page=home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="?page=produtos">Produtos</a></li>
        <li class="nav-item"><a class="nav-link" href="?page=carrinho">Carrinho</a></li>
      </ul>
      
      <div class="d-flex align-items-center ms-auto">
        <?php if(isset($_SESSION['usuario_id'])): ?>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-white" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar me-2">
                        <?php echo strtoupper(substr($_SESSION['nome'] ?? 'U', 0, 1)); ?>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="#">Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="?page=logout">Sair</a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="?page=login" class="btn-login-nav">
                <i class="bi bi-person-circle fs-5"></i>
                <span>Fazer Login</span>
            </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<div class="container"></div>