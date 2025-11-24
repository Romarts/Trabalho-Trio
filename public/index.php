<?php
// 1. Inicia a Sessão (Obrigatório para Login e Carrinho funcionarem)
session_start();

// 2. Carrega o Cabeçalho (Menu do topo)
require_once '../app/views/templates/header.php';

// 3. Captura qual página o usuário quer acessar (ex: index.php?page=login)
$pagina = isset($_GET['page']) ? $_GET['page'] : 'home';

// 4. Roteador: Decide qual arquivo carregar baseado na página
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

        // --- ÁREA DE ADMINISTRADORES ---
case 'admin':
    require_once '../app/controllers/AdminController.php';
    $admin = new AdminController();
    $admin->dashboard();
    break;

case 'criar-admin':
    require_once '../app/controllers/AdminController.php';
    $admin = new AdminController();
    $admin->criarAdmin();
    break;

case 'salvar-admin':
    require_once '../app/controllers/AdminController.php';
    $admin = new AdminController();
    $admin->salvarAdmin();
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
        
        // Se tiver um ID na URL (ex: &add=5), adiciona o produto
        if (isset($_GET['add'])) {
            $id_produto = $_GET['add'];
            $carrinho->adicionar($id_produto);
        } else {
            // Se não, apenas mostra a lista do carrinho
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
        
        // Mensagem de boas-vindas personalizada
        if(isset($_SESSION['usuario_nome'])) {
            echo "<p class='lead text-success'>Olá, <strong>" . htmlspecialchars($_SESSION['usuario_nome']) . "</strong>! Boas compras.</p>";
        } else {
            echo "<p class='lead'>Faça login para aproveitar as melhores ofertas.</p>";
        }
        echo "</div>";

        // --- ÁREA RESTRITA DO ADMIN (DASHBOARD) ---
        // A Lógica:
        // 1. isset(...): A pessoa está logada?
        // 2. ... == 'admin': A pessoa é chefe?
        // Se falhar em qualquer um dos dois (incluindo quem não tá logado), pula tudo isso.
        
        if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] == 'admin') {
            
            echo "<hr class='my-4'>";
            echo "<div class='bg-light p-4 rounded border shadow-sm'>"; // Um container para destacar o painel
                echo "<h3 class='mb-4 text-center text-danger'>Painel Administrativo (Apenas Admin)</h3>";
                
                echo "<div class='row text-center'>
                        <div class='col-md-4'>
                            <div class='card text-white bg-primary mb-3'>
                                <div class='card-header'>Estoque Total</div>
                                <div class='card-body'>
                                    <h2 class='card-title'>500+</h2>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class='card text-white bg-success mb-3'>
                                <div class='card-header'>Faturamento Hoje</div>
                                <div class='card-body'>
                                    <h2 class='card-title'>R$ 1.250,00</h2>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class='card text-white bg-dark mb-3'>
                                <div class='card-header'>Clientes Novos</div>
                                <div class='card-body'>
                                    <h2 class='card-title'>15</h2>
                                </div>
                            </div>
                        </div>
                      </div>";
                
                // Botões extras exclusivos para Admin
                echo "<div class='text-center mt-3'>
                        <a href='?page=criar-admin' class='btn btn-outline-danger btn-sm'>Criar Novo Admin</a>
                      </div>";
            echo "</div>"; // Fim do container do painel
        } 
        // --- FIM DA ÁREA RESTRITA ---

        // Área Pública (Produtos) - Todo mundo vê
        echo "<div class='text-center mt-5'>";
            echo "<h4 class='mb-3'>Confira nossas ofertas</h4>";
            echo "<a href='?page=produtos' class='btn btn-primary btn-lg'>Ver Todos os Produtos</a>";
        echo "</div>";
        break;
}

// 5. Carrega o Rodapé (Fecha o HTML)
require_once '../app/views/templates/footer.php';
?>