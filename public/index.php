<?php
// 1. Inicia a Sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Carrega o Cabeçalho
require_once '../app/views/templates/header.php';

// 3. Captura qual página o usuário quer acessar
$pagina = isset($_GET['page']) ? $_GET['page'] : 'home';

// 4. Roteador
switch ($pagina) {
    
    // --- ÁREA DE ACESSO (LOGIN/LOGOUT) ---
    case 'login':
        require_once '../app/controllers/AuthController.php';
        $auth = new AuthController();
        $auth->login();
        break;

    case 'cadastrar':
        require_once '../app/controllers/AuthController.php';
        $auth = new AuthController();
        $auth->cadastrar();
        break;
        
    case 'logout':
        require_once '../app/controllers/AuthController.php';
        $auth = new AuthController();
        $auth->logout();
        break;

    // --- ÁREA DO CARRINHO (ATUALIZADA) ---
    // Adicionei 'atualizar_carrinho' para funcionar com o visual novo
    case 'atualizar':
    case 'atualizar_carrinho': 
        require_once '../app/controllers/CarrinhoController.php';
        $carrinho = new CarrinhoController();
        $carrinho->atualizar();
        break;

    // Adicionei 'remover_item' para funcionar com o visual novo (ícone da lixeira)
    case 'remover':
    case 'remover_item':
        require_once '../app/controllers/CarrinhoController.php';
        $carrinho = new CarrinhoController();
        
        if (isset($_GET['id'])) {
            $id_produto = $_GET['id'];
            $carrinho->remover($id_produto);
        } else {
            header('Location: ?page=carrinho');
        }
        break;

    case 'carrinho':
        require_once '../app/controllers/CarrinhoController.php';
        $carrinho = new CarrinhoController();
        
        if (isset($_GET['add'])) {
            $id_produto = $_GET['add'];
            $carrinho->adicionar($id_produto);
        } else {
            $carrinho->listar();
        }
        break;

    case 'finalizar':
        require_once '../app/controllers/CarrinhoController.php';
        $carrinho = new CarrinhoController();
        $carrinho->finalizar();
        break;

    // --- ÁREA DE ADMINISTRADORES (MANTIDA ORIGINAL) ---

    case 'admin-vendas':
        require_once '../app/controllers/AdminController.php';
        $admin = new AdminController();
        $admin->vendas();
        break;

    case 'admin-clientes':
        require_once '../app/controllers/AdminController.php';
        $admin = new AdminController();
        $admin->clientes();
        break;

    case 'admin-cliente-form':
        require_once '../app/controllers/AdminController.php';
        $admin = new AdminController();
        $admin->formCliente();
        break;

    case 'admin-cliente-salvar':
        require_once '../app/controllers/AdminController.php';
        $admin = new AdminController();
        $admin->salvarCliente();
        break;

    case 'admin-excluir-cliente':
        require_once '../app/controllers/AdminController.php';
        $admin = new AdminController();
        $admin->excluirCliente();
        break;

    case 'admin-produtos':
        require_once '../app/controllers/AdminController.php';
        $admin = new AdminController();
        $admin->index();
        break;

    case 'admin-form':
        require_once '../app/controllers/AdminController.php';
        $admin = new AdminController();
        $admin->form();
        break;

    case 'admin-salvar':
        require_once '../app/controllers/AdminController.php';
        $admin = new AdminController();
        $admin->salvar();
        break;

    case 'admin-excluir':
        require_once '../app/controllers/AdminController.php';
        $admin = new AdminController();
        $admin->excluir();
        break;

    // --- ÁREA DE PRODUTOS ---
    case 'produtos':
        require_once '../app/controllers/ProdutoController.php';
        $controller = new ProdutoController();
        $controller->listar();
        break;

    // --- PÁGINA INICIAL (HOME) ---
    default:
        echo "<div class='py-5 text-center'>";
        echo "<h1 class='display-4'>Bem-vindo à Loja Faculdade</h1>";
        
        // Mensagem de boas-vindas
        if(isset($_SESSION['usuario_nome'])) {
            echo "<p class='lead text-success'>Olá, <strong>" . htmlspecialchars($_SESSION['usuario_nome']) . "</strong>! Boas compras.</p>";
        } else {
            echo "<p class='lead'>Faça login para aproveitar as melhores ofertas.</p>";
        }
        echo "</div>";

        // --- DASHBOARD RESTRITO (SÓ ADMIN VÊ - MANTIDO ORIGINAL) ---
        if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] == 'admin') {
            
            require_once '../app/models/Produto.php';
            require_once '../app/models/Usuario.php';
            // require_once '../app/models/Pedido.php'; 

            $estoqueReal = 0;
            $faturamentoReal = 0;
            $clientesReais = 0;

            // Verificações de segurança para evitar erro fatal se o arquivo não existir
            if(class_exists('Produto')) {
                $pModel = new Produto();
                if(method_exists($pModel, 'contarEstoqueTotal')) {
                    $estoqueReal = $pModel->contarEstoqueTotal();
                }
            }
            if(class_exists('Usuario')) {
                $uModel = new Usuario();
                if(method_exists($uModel, 'contarClientes')) {
                    $clientesReais = $uModel->contarClientes();
                }
            }
            if(class_exists('Pedido')) {
                $pedModel = new Pedido();
                if(method_exists($pedModel, 'faturamentoHoje')) {
                    $faturamentoReal = $pedModel->faturamentoHoje();
                }
            }

            echo "<hr class='my-4'>";
            echo "<div class='bg-light p-4 rounded border shadow-sm'>";
                echo "<h3 class='mb-4 text-center text-danger'>Painel Administrativo (Apenas Admin)</h3>";
                
                echo "<div class='text-center mb-4 gap-2 d-flex justify-content-center'>
                        <a href='?page=admin-produtos' class='btn btn-danger'>GERENCIAR PRODUTOS</a>
                        <a href='?page=admin-vendas' class='btn btn-success'>VER VENDAS</a>
                        <a href='?page=admin-clientes' class='btn btn-warning'>GERENCIAR CLIENTES</a>
                      </div>";

                echo "<div class='row text-center'>
                        <div class='col-md-4'>
                            <div class='card text-white bg-primary mb-3'>
                                <div class='card-header'>Estoque Total</div>
                                <div class='card-body'>
                                    <h2 class='card-title'>" . $estoqueReal . "</h2>
                                    <p class='card-text'>unidades</p>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class='card text-white bg-success mb-3'>
                                <div class='card-header'>Faturamento Hoje</div>
                                <div class='card-body'>
                                    <h2 class='card-title'>R$ " . number_format($faturamentoReal, 2, ',', '.') . "</h2>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class='card text-white bg-dark mb-3'>
                                <div class='card-header'>Total de Clientes</div>
                                <div class='card-body'>
                                    <h2 class='card-title'>" . $clientesReais . "</h2>
                                </div>
                            </div>
                        </div>
                      </div>";
            echo "</div>"; 
        }
        
        // Área Pública
        echo "<div class='text-center mt-5'>";
            echo "<h4 class='mb-3'>Confira nossas ofertas</h4>";
            echo "<a href='?page=produtos' class='btn btn-primary btn-lg'>Ver Todos os Produtos</a>";
        echo "</div>";
        break;
}

// 5. Carrega o Rodapé
require_once '../app/views/templates/footer.php';
?>

<!-- SCRIPT DE SENHA (MANTIDO ORIGINAL) -->
<script>
function mostrarSenha() {
    var inputPass = document.getElementById('senha');
    var btnIcon = document.getElementById('iconeSenha');

    if (inputPass.type === "password") {
        inputPass.type = "text"; 
        btnIcon.classList.remove('bi-eye'); 
        btnIcon.classList.add('bi-eye-slash'); 
    } else {
        inputPass.type = "password"; 
        btnIcon.classList.remove('bi-eye-slash'); 
        btnIcon.classList.add('bi-eye'); 
    }
}
</script>