<?php
// 1. Inicia a Sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Carrega o Cabeçalho
require_once '../app/views/templates/header.php';

// 3. Captura a página
$pagina = isset($_GET['page']) ? $_GET['page'] : 'home';

// 4. Roteador
switch ($pagina) {
    
    // --- ÁREA DE ACESSO ---
    case 'login': require_once '../app/controllers/AuthController.php'; $a = new AuthController(); $a->login(); break;
    case 'cadastrar': require_once '../app/controllers/AuthController.php'; $a = new AuthController(); $a->cadastrar(); break;
    case 'logout': require_once '../app/controllers/AuthController.php'; $a = new AuthController(); $a->logout(); break;

    // --- CARRINHO ---
    case 'atualizar': case 'atualizar_carrinho': 
        require_once '../app/controllers/CarrinhoController.php'; $c = new CarrinhoController(); $c->atualizar(); break;
    case 'remover': case 'remover_item':
        require_once '../app/controllers/CarrinhoController.php'; $c = new CarrinhoController();
        if (isset($_GET['id'])) $c->remover($_GET['id']); else header('Location: ?page=carrinho'); break;
    case 'carrinho':
        require_once '../app/controllers/CarrinhoController.php'; $c = new CarrinhoController();
        if (isset($_GET['add'])) $c->adicionar($_GET['add']); else $c->listar(); break;
    case 'finalizar':
        require_once '../app/controllers/CarrinhoController.php'; $c = new CarrinhoController(); $c->finalizar(); break;

    // --- ADMIN (Rotas mantidas) ---
    case 'admin-vendas': require_once '../app/controllers/AdminController.php'; $adm = new AdminController(); $adm->vendas(); break;
    case 'admin-clientes': require_once '../app/controllers/AdminController.php'; $adm = new AdminController(); $adm->clientes(); break;
    case 'admin-cliente-form': require_once '../app/controllers/AdminController.php'; $adm = new AdminController(); $adm->formCliente(); break;
    case 'admin-cliente-salvar': require_once '../app/controllers/AdminController.php'; $adm = new AdminController(); $adm->salvarCliente(); break;
    case 'admin-excluir-cliente': require_once '../app/controllers/AdminController.php'; $adm = new AdminController(); $adm->excluirCliente(); break;
    case 'admin-produtos': require_once '../app/controllers/AdminController.php'; $adm = new AdminController(); $adm->index(); break;
    case 'admin-form': require_once '../app/controllers/AdminController.php'; $adm = new AdminController(); $adm->form(); break;
    case 'admin-salvar': require_once '../app/controllers/AdminController.php'; $adm = new AdminController(); $adm->salvar(); break;
    case 'admin-excluir': require_once '../app/controllers/AdminController.php'; $adm = new AdminController(); $adm->excluir(); break;

    // --- PRODUTOS ---
    case 'produtos':
        require_once '../app/controllers/ProdutoController.php';
        $controller = new ProdutoController();
        $controller->listar();
        break;

    // --- HOME PAGE (VERSÃO MADEIRA / RÚSTICA) ---
    default:
        // Painel Admin (SÓ PARA ADMIN)
        if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] == 'admin') {
            $estoque = 0; $vendas = 0; $clientes = 0;
            if(file_exists('../app/models/Produto.php')) { require_once '../app/models/Produto.php'; if(class_exists('Produto')) { $m=new Produto(); if(method_exists($m,'contarEstoqueTotal')) $estoque=$m->contarEstoqueTotal(); }}
            if(file_exists('../app/models/Usuario.php')) { require_once '../app/models/Usuario.php'; if(class_exists('Usuario')) { $m=new Usuario(); if(method_exists($m,'contarClientes')) $clientes=$m->contarClientes(); }}
            if(file_exists('../app/models/Pedido.php')) { require_once '../app/models/Pedido.php'; if(class_exists('Pedido')) { $m=new Pedido(); if(method_exists($m,'faturamentoHoje')) $vendas=$m->faturamentoHoje(); }}

            echo "<div class='container mt-3'><div class='alert alert-secondary border-0 shadow-sm' style='background-color: #f8f9fa;'>";
            echo "<h5 class='text-center mb-3 text-muted'><i class='bi bi-tools'></i> Painel do Artesão (Admin)</h5>";
            echo "<div class='row text-center'>
                    <div class='col-md-4'><strong>Peças no Estoque:</strong> $estoque</div>
                    <div class='col-md-4'><strong>Vendas Hoje:</strong> R$ ".number_format($vendas,2,',','.')."</div>
                    <div class='col-md-4'><strong>Clientes:</strong> $clientes</div>
                  </div>";
            echo "<div class='text-center mt-3'><a href='?page=admin-produtos' class='btn btn-sm btn-dark'>Acessar Oficina</a></div>";
            echo "</div></div>";
        }
        ?>

        <!-- 1. Banner Principal (Hero) - Estilo Madeira -->
        <div class="p-5 mb-5 text-white rounded-0 text-center" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1604085572504-a392ebf03049?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'); background-size: cover; background-position: center; border-bottom: 5px solid #8B4513;">
            <div class="container py-5">
                <h1 class="display-3 fw-bold" style="text-shadow: 2px 2px 4px #000;">Arte & Madeira</h1>
                <p class="fs-4 mb-4 text-light">Decoração rústica e móveis artesanais para deixar seu lar aconchegante.</p>
                <a href="?page=produtos" class="btn btn-lg px-5 py-3 fw-bold rounded-pill shadow" style="background-color: #8B4513; border: none; color: white;">Ver Coleção</a>
            </div>
        </div>

        <!-- 2. Conceitos (Vantagens) -->
        <div class="container mb-5">
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <div class="p-4 border rounded shadow-sm h-100">
                        <i class="bi bi-tree fs-1 text-success"></i>
                        <h4 class="mt-3">Madeira Sustentável</h4>
                        <p class="text-muted">Trabalhamos apenas com madeira de reflorestamento certificada.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 border rounded shadow-sm h-100">
                        <i class="bi bi-hammer fs-1" style="color: #8B4513;"></i>
                        <h4 class="mt-3">Feito à Mão</h4>
                        <p class="text-muted">Cada peça é única, produzida artesanalmente com carinho.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 border rounded shadow-sm h-100">
                        <i class="bi bi-heart fs-1 text-danger"></i>
                        <h4 class="mt-3">Design Exclusivo</h4>
                        <p class="text-muted">Peças que trazem personalidade e calor para o seu ambiente.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Categorias (Madeira) -->
        <div class="bg-light py-5">
            <div class="container">
                <h2 class="text-center mb-5 fw-bold text-dark">Explore Nossas Categorias</h2>
                <div class="row g-4">
                    <!-- Card 1 -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-lg h-100 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1538688521862-98aa01ac46d3?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img" alt="Móveis" style="height: 300px; object-fit: cover; filter: brightness(0.7);">
                            <div class="card-img-overlay d-flex flex-column justify-content-end p-4">
                                <h3 class="card-title fw-bold text-white">Móveis Rústicos</h3>
                                <a href="?page=produtos" class="btn btn-light mt-2 stretched-link">Ver Móveis</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-lg h-100 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1513519245088-0e12902e5a38?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img" alt="Decoração" style="height: 300px; object-fit: cover; filter: brightness(0.7);">
                            <div class="card-img-overlay d-flex flex-column justify-content-end p-4">
                                <h3 class="card-title fw-bold text-white">Decoração de Parede</h3>
                                <a href="?page=produtos" class="btn btn-light mt-2 stretched-link">Ver Decoração</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-lg h-100 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1610701596007-11502861dcfa?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img" alt="Utensílios" style="height: 300px; object-fit: cover; filter: brightness(0.7);">
                            <div class="card-img-overlay d-flex flex-column justify-content-end p-4">
                                <h3 class="card-title fw-bold text-white">Utensílios & Cozinha</h3>
                                <a href="?page=produtos" class="btn btn-light mt-2 stretched-link">Ver Utensílios</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Newsletter -->
        <div class="container py-5 text-center">
            <h2 class="fw-bold mb-3">Junte-se ao Clube da Madeira</h2>
            <p class="text-muted mb-4">Receba dicas de decoração e ofertas de peças únicas.</p>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control form-control-lg" placeholder="Seu e-mail" aria-label="Seu e-mail">
                        <button class="btn btn-dark" type="button" onclick="alert('Inscrito com sucesso!')">Inscrever-se</button>
                    </div>
                </div>
            </div>
        </div>

        <?php
        break;
}

// 5. Rodapé
require_once '../app/views/templates/footer.php';
?>

<script>
function mostrarSenha() {
    var i = document.getElementById('senha'); var b = document.getElementById('iconeSenha');
    if (i.type === "password") { i.type = "text"; b.classList.replace('bi-eye', 'bi-eye-slash'); }
    else { i.type = "password"; b.classList.replace('bi-eye-slash', 'bi-eye'); }
}
</script>