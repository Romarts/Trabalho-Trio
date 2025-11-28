<?php
// 1. Inicia a Sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Carrega o Cabeçalho
require_once '../app/views/templates/header.php';

// 3. Roteador Principal
$pagina = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($pagina) {
    
    // --- AUTENTICAÇÃO ---
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

    case 'pagamento': include '../app/views/site/pagamento.php'; break;
    
    case 'finalizar':
        require_once '../app/controllers/CarrinhoController.php'; 
        $c = new CarrinhoController(); 
        $c->finalizar(); 
        break;

    // --- ADMINISTRAÇÃO ---
    case 'admin-vendas': require_once '../app/controllers/AdminController.php'; $adm = new AdminController(); $adm->vendas(); break;
    case 'admin-clientes': require_once '../app/controllers/AdminController.php'; $adm = new AdminController(); $adm->clientes(); break;
    case 'admin-cliente-form': require_once '../app/controllers/AdminController.php'; $adm = new AdminController(); $adm->formCliente(); break;
    case 'admin-cliente-salvar': require_once '../app/controllers/AdminController.php'; $adm = new AdminController(); $adm->salvarCliente(); break;
    case 'admin-excluir-cliente': require_once '../app/controllers/AdminController.php'; $adm = new AdminController(); $adm->excluirCliente(); break;
    
    case 'admin-produtos': require_once '../app/controllers/AdminController.php'; $adm = new AdminController(); $adm->index(); break;
    case 'admin-form': require_once '../app/controllers/AdminController.php'; $adm = new AdminController(); $adm->form(); break;
    case 'admin-excluir': require_once '../app/controllers/AdminController.php'; $adm = new AdminController(); $adm->excluir(); break;
    
    // --- ROTAS DE SALVAMENTO DE PRODUTO ---
    case 'admin-salvar': // Mantive caso algum link antigo ainda aponte pra cá
    case 'fotos_produtos':
    // Avisamos que está lá na pasta de views/site
    include '../app/views/site/fotos_produtos.php'; 
    break;

    // --- ÁREA PÚBLICA (PRODUTOS) ---
    case 'produtos':
        require_once '../app/controllers/ProdutoController.php';
        $controller = new ProdutoController();
        $controller->listar();
        break;

    // --- HOME PAGE (RÚSTICA / ARTE & MADEIRA) ---
    case 'home':
    default:
        // Painel Admin (SÓ VISÍVEL PARA ADMIN)
        if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] == 'admin') {
            $estoque = 0; $vendas = 0; $clientes = 0;
            // Verifica arquivos antes de tentar carregar para evitar erros
            if(file_exists('../app/models/Produto.php')) { require_once '../app/models/Produto.php'; if(class_exists('Produto')) { $m=new Produto(); if(method_exists($m,'contarEstoqueTotal')) $estoque=$m->contarEstoqueTotal(); }}
            if(file_exists('../app/models/Usuario.php')) { require_once '../app/models/Usuario.php'; if(class_exists('Usuario')) { $m=new Usuario(); if(method_exists($m,'contarClientes')) $clientes=$m->contarClientes(); }}
            if(file_exists('../app/models/Pedido.php')) { require_once '../app/models/Pedido.php'; if(class_exists('Pedido')) { $m=new Pedido(); if(method_exists($m,'faturamentoHoje')) $vendas=$m->faturamentoHoje(); }}

            echo "<div class='container mt-3'><div class='alert alert-secondary border-0 shadow-sm' style='background-color: #f8f9fa; border-left: 5px solid #8B4513;'>";
            echo "<h5 class='text-center mb-3 text-muted' style='font-family: Georgia, serif;'><i class='bi bi-tools'></i> Painel do Artesão</h5>";
            echo "<div class='row text-center'>
                    <div class='col-md-4'><strong>Peças no Estoque:</strong> $estoque</div>
                    <div class='col-md-4'><strong>Vendas Hoje:</strong> R$ ".number_format($vendas,2,',','.')."</div>
                    <div class='col-md-4'><strong>Clientes:</strong> $clientes</div>
                  </div>";
            echo "<div class='text-center mt-3'><a href='?page=admin-produtos' class='btn btn-sm text-white' style='background-color: #8B4513;'>Acessar Oficina</a></div>";
            echo "</div></div>";
        }
        ?>

        <div class="p-5 mb-5 text-white rounded-0 text-center" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1604085572504-a392ebf03049?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'); background-size: cover; background-position: center; border-bottom: 5px solid #8B4513;">
            <div class="container py-5">
                <h1 class="display-3 fw-bold" style="text-shadow: 2px 2px 4px #000; font-family: 'Georgia', serif;">Arte & Madeira</h1>
                <p class="fs-4 mb-4 text-light">Decoração rústica e móveis artesanais para deixar seu lar aconchegante.</p>
                <a href="?page=produtos" class="btn btn-lg px-5 py-3 fw-bold rounded-pill shadow" style="background-color: #8B4513; border: none; color: white;">Ver Coleção</a>
            </div>
        </div>

        <div class="container mb-5">
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <div class="p-4 border rounded shadow-sm h-100">
                        <i class="bi bi-tree fs-1 text-success"></i>
                        <h4 class="mt-3" style="font-family: 'Georgia', serif;">Madeira Sustentável</h4>
                        <p class="text-muted">Trabalhamos apenas com madeira de reflorestamento certificada.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 border rounded shadow-sm h-100">
                        <i class="bi bi-hammer fs-1" style="color: #8B4513;"></i>
                        <h4 class="mt-3" style="font-family: 'Georgia', serif;">Feito à Mão</h4>
                        <p class="text-muted">Cada peça é única, produzida artesanalmente com carinho.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 border rounded shadow-sm h-100">
                        <i class="bi bi-heart fs-1 text-danger"></i>
                        <h4 class="mt-3" style="font-family: 'Georgia', serif;">Design Exclusivo</h4>
                        <p class="text-muted">Peças que trazem personalidade e calor para o seu ambiente.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-light py-5">
            <div class="container">
                <h2 class="text-center mb-5 fw-bold text-dark" style="font-family: 'Georgia', serif;">Explore Nossas Categorias</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-lg h-100 overflow-hidden">
                            <img src="https://allmadloja.com.br/wp-content/uploads/2019/10/M%C3%B3veis-de-madeira-para-o-interior-da-casa.webp" class="card-img" alt="Móveis" style="height: 300px; object-fit: cover; filter: brightness(0.7);">
                            <div class="card-img-overlay d-flex flex-column justify-content-end p-4">
                                <h3 class="card-title fw-bold text-white">Móveis Rústicos</h3>
                                <a href="?page=produtos" class="btn btn-light mt-2 stretched-link">Ver Móveis</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-lg h-100 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1513519245088-0e12902e5a38?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img" alt="Decoração" style="height: 300px; object-fit: cover; filter: brightness(0.7);">
                            <div class="card-img-overlay d-flex flex-column justify-content-end p-4">
                                <h3 class="card-title fw-bold text-white">Decoração de Parede</h3>
                                <a href="?page=produtos" class="btn btn-light mt-2 stretched-link">Ver Decoração</a>
                            </div>
                        </div>
                    </div>
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

        <div class="container py-5 text-center">
            <h2 class="fw-bold mb-3" style="font-family: 'Georgia', serif;">Junte-se ao Clube da Madeira</h2>
            <p class="text-muted mb-4">Receba dicas de decoração e ofertas de peças únicas.</p>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control form-control-lg" placeholder="Seu e-mail" aria-label="Seu e-mail">
                        <button class="btn text-white" style="background-color: #8B4513;" type="button" onclick="alert('Inscrito com sucesso!')">Inscrever-se</button>
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