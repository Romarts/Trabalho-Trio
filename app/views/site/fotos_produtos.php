<?php
// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ?page=login');
    exit;
}

// 1. Coleta os dados do formulário
$id = $_POST['id'] ?? null;
$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$preco = $_POST['preco'];
$estoque = $_POST['estoque'];
$imagem_antiga = $_POST['imagem_antiga'] ?? '';

// Caminho padrão
$caminho_imagem = $imagem_antiga;

// 2. Lógica de Upload da Imagem
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    
    // ATENÇÃO: Se a pasta for 'img', mantenha 'img/'. Se for 'imagens', mude para 'imagens/'
    $diretorio = 'img/'; 
    
    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0755, true);
    }

    $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (in_array($extensao, $permitidas)) {
        $novo_nome = uniqid('prod_') . '.' . $extensao;
        $destino = $diretorio . $novo_nome;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
            $caminho_imagem = $destino; 
        }
    } else {
        die("Erro: Formato inválido. Apenas JPG, PNG e WebP.");
    }
}

// 3. Salvar no Banco
try {
    // --- CORREÇÃO AQUI: GARANTIR A CONEXÃO ---
    // Verifica se a conexão já existe. Se não, cria uma nova.
    if (!isset($conn)) {
        // Ajuste o caminho conforme onde está seu arquivo database.php
        // Geralmente fica em ../config/database.php ou ../app/config/database.php
        
        // Tenta achar o arquivo de config
        if (file_exists('../config/database.php')) {
            require_once '../config/database.php';
        } elseif (file_exists('../app/config/database.php')) {
            require_once '../app/config/database.php';
        }
        
        // Se você usa uma classe Database, instancie ela:
        if (class_exists('Database')) {
            $db = new Database();
            $conn = $db->getConnection();
        } else {
            // Se você não usa classe e faz conexão direta (mysqli_connect), 
            // verifique onde ela é feita.
            
            // TENTATIVA MANUAL (Caso os arquivos acima falhem, descomente e preencha):
            // $conn = new mysqli('localhost', 'root', '', 'loja_faculdade');
        }
    }

    // Se mesmo assim $conn for nulo, paramos o script para não dar erro fatal
    if (!$conn) {
        die("Erro crítico: Não foi possível conectar ao banco de dados em fotos_produtos.php");
    }
    // ------------------------------------------

    if ($id) {
        // UPDATE
        $sql = "UPDATE produtos SET nome=?, descricao=?, preco=?, estoque=?, imagem=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdiss", $nome, $descricao, $preco, $estoque, $caminho_imagem, $id);
        $msg = "Produto atualizado com sucesso!";
    } else {
        // INSERT
        $sql = "INSERT INTO produtos (nome, descricao, preco, estoque, imagem) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdis", $nome, $descricao, $preco, $estoque, $caminho_imagem);
        $msg = "Produto cadastrado com sucesso!";
    }

if ($stmt->execute()) {

        echo "<script>window.location.href='?page=admin-produtos&msg=" . urlencode($msg) . "';</script>";
        exit;
    } else {
        echo "Erro ao salvar: " . $stmt->error;
    }

} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>