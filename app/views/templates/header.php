<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Arte e Madeira</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* --- TEMA RÚSTICO (Arte & Madeira) --- */
        
        :root {
            --cor-madeira: #A0522D; /* Marrom Sienna */
            --cor-madeira-escura: #8B4513;
            --fundo-escuro: #2c2a29; /* Cinza Café */
        }

        .navbar-custom {
            background-color: var(--fundo-escuro);
            border-bottom: 4px solid var(--cor-madeira);
            padding: 0.8rem 0;
        }

        /* Marca / Logo */
        .navbar-brand {
            font-weight: bold;
            letter-spacing: 1px;
            color: white !important;
            display: flex;
            align-items: center;
            font-family: 'Georgia', serif; /* Fonte mais clássica */
        }

        /* Ícone da logo */
        .logo-icon {
            color: var(--cor-madeira);
        }

        /* Links do Menu */
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            font-weight: 500;
            margin-left: 10px;
            transition: all 0.3s;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--cor-madeira) !important;
        }

        /* Botão de Login (Rústico) */
        .btn-login-nav {
            background-color: transparent;
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 4px; /* Bordas levemente arredondadas, menos "tech" */
            padding: 8px 20px;
            font-size: 0.9rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .btn-login-nav:hover {
            border-color: var(--cor-madeira);
            background-color: var(--cor-madeira);
            color: white;
        }

        /* Avatar do Usuário */
        .user-avatar {
            width: 35px;
            height: 35px;
            background-color: var(--cor-madeira);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-5">
  <div class="container-fluid px-4"> 
    
    <a class="navbar-brand" href="index.php">
        <i class="bi bi-tree-fill me-2 logo-icon"></i> Arte & Madeira
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="?page=home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="?page=produtos">Coleção</a></li>
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
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li><a class="dropdown-item" href="#">Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="?page=logout">Sair</a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="?page=login" class="btn-login-nav">
                <i class="bi bi-person fs-5"></i>
                <span>Entrar</span>
            </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<div class="container"></div>