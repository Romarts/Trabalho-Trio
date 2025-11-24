<?php
// 1. Inicia a Sessão (Obrigatório para Login e Carrinho funcionarem)
// Verifica status para não dar erro se o servidor já tiver iniciado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Carrega o Cabeçalho (Menu do topo)
require_once '../app/views/templates/header.php';

// 3. Captura qual página o usuário quer acessar
$pagina = isset($_GET['page']) ? $_GET['page'] : 'home';

// 4. Roteador: Decide qual arquivo carregar baseado na página
switch ($pagina) {
    
    // --- ÁREA DE ACESSO (LOGIN/LOGOUT) ---
    // Usamos AuthController padronizado
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

    // --- ÁREA DE ADMINISTRADORES (CRUD DE PRODUTOS) ---
    // Estas são as rotas que valem nota!
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

    // --- ÁREA DO CARRINHO DE COMPRAS ---
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

        // --- DASHBOARD RESTRITO (SÓ ADMIN VÊ) ---
        if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] == 'admin') {
            
            echo "<hr class='my-4'>";
            echo "<div class='bg-light p-4 rounded border shadow-sm'>";
                echo "<h3 class='mb-4 text-center text-danger'>Painel Administrativo (Apenas Admin)</h3>";
                
                // Botão principal para acessar o CRUD
                echo "<div class='text-center mb-4'>
                        <a href='?page=admin-produtos' class='btn btn-danger btn-lg'>GERENCIAR PRODUTOS (CRUD)</a>
                      </div>";

                echo "<div class='row text-center'>
                        <div class='col-md-4'>
                            <div class='card text-white bg-primary mb-3'>
                                <div class='card-header'>Estoque Total</div>
                                <div class='card-body'><h2 class='card-title'>500+</h2></div>
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class='card text-white bg-success mb-3'>
                                <div class='card-header'>Faturamento Hoje</div>
                                <div class='card-body'><h2 class='card-title'>R$ 1.250,00</h2></div>
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class='card text-white bg-dark mb-3'>
                                <div class='card-header'>Clientes Novos</div>
                                <div class='card-body'><h2 class='card-title'>15</h2></div>
                            </div>
                        </div>
                      </div>";
            echo "</div>"; 
        } 
        
        // Área Pública (Produtos)
        echo "<div class='text-center mt-5'>";
            echo "<h4 class='mb-3'>Confira nossas ofertas</h4>";
            echo "<a href='?page=produtos' class='btn btn-primary btn-lg'>Ver Todos os Produtos</a>";
        echo "</div>";
        break;
}

// 5. Carrega o Rodapé
require_once '../app/views/templates/footer.php';
?>