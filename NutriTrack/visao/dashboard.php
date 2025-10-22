<?php
// Iniciar sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['id']) || !isset($_SESSION['tipo'])) {
    header("Location: login.php");  // Redirecionar se não logado
    exit;
}

// Definir raiz para includes
define('ROOT_PATH', __DIR__ . '/../');

// Incluir classes necessárias
require_once ROOT_PATH . 'modelo/Cliente/ClienteDAO_class.php';
require_once ROOT_PATH . 'modelo/Nutricionista/NutricionistaDAO_class.php';
require_once ROOT_PATH . 'modelo/Cliente/Cliente_class.php';
require_once ROOT_PATH . 'modelo/Nutricionista/Nutricionista_class.php';

// Obter dados da sessão
$usuario_id = $_SESSION['id'];
$tipo = $_SESSION['tipo'];

// Buscar dados do usuário baseado no tipo
$dao = ($tipo == 'nutricionista') ? new NutricionistaDAO() : new ClienteDAO();
$usuario = $dao->buscarPorId($usuario_id);

// Se usuário não encontrado, redirecionar
if (!$usuario) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Processar atualização se formulário enviado
$sucesso = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Atualizar campos
    $usuario->setNome($_POST['nome']);
    $usuario->setEmail($_POST['email']);
    if ($tipo == 'cliente') {
        $usuario->setIdade($_POST['idade']);
        $usuario->setPeso($_POST['peso']);
        $usuario->setAltura($_POST['altura']);
    }
    if (!empty($_POST['senha'])) {
        $usuario->setSenha(password_hash($_POST['senha'], PASSWORD_DEFAULT));
    }

    // Salvar no banco
    if ($dao->alterar($usuario)) {
        $sucesso = true;
        // Recarregar dados após atualização
        $usuario = $dao->buscarPorId($usuario_id);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        *{
            box-sizing: border-box;
        }
        body { 
            font-family: Arial, sans-serif; 
            background-color: #f4f4f4; 
            margin: 0; 
            padding-top: 2%; 
        }
        .dashboard-container { 
            max-width: 600px; 
            margin: auto; 
            background: white; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0,0,0,0.1); 
        }
        h1 { 
            text-align: center; 
            color: #333; 
        }
        .dados { 
            margin-top: 20px; 
        }
        .foto {
			margin-bottom: 15px;
		}
		.foto img {
			width: 120px;
			height: 120px;
			object-fit: cover;
			border-radius: 50%;
		}
        label { 
            display: block; 
            margin-bottom: 5px; 
            font-weight: bold; 
        }
        input { 
            width: 100%; 
            padding: 8px; 
            margin-bottom: 15px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
        }
        button { 
            width: 100%; 
            padding: 10px; 
            background-color: #28a745; 
            color: white; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
        }
        button:hover { 
            background-color: #218838; 
        }
        .sucesso { 
            color: green; 
            text-align: center; 
            margin-bottom: 15px; 
        }
        .logout { 
            text-align: center; 
            margin-top: 20px; 
        }
        .logout a { 
            color: #d9534f; 
            text-decoration: none; 
            font-weight: bold; 
        }
        .logout a:hover { 
            text-decoration: underline; 
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Dashboard - <?php echo ucfirst($tipo); ?></h1>
        
        <?php if ($sucesso) echo "<p class='sucesso'>Dados atualizados com sucesso!</p>"; ?>
        <?php if (isset($erro)) echo "<p class='erro'>$erro</p>"; ?>
        
        <form method="POST" class="dados">
            <h2>Seus Dados</h2>
            
            <?php
            $foto = !empty($usuario->getFoto()) ? $usuario->getFoto() : 'uploads/nutricionistas/default.png';
    		echo "<div class='foto'><img src='../" . htmlspecialchars($foto) . "' alt='Foto de " . htmlspecialchars($usuario->getNome()) . "' /></div>";
            ?>
            <input type="file" name="foto" accept="image/*" style="border: none;margin:0;padding:0;">
            
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($usuario->getNome()); ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($usuario->getEmail()); ?>" required readonly>
            
            <?php if ($tipo == 'cliente'): ?>
                <label for="idade">Idade:</label>
                <input type="number" name="idade" id="idade" value="<?php echo htmlspecialchars($usuario->getIdade()); ?>" required>
                
                <label for="peso">Peso (kg):</label>
                <input type="number" step="0.01" name="peso" id="peso" value="<?php echo htmlspecialchars($usuario->getPeso()); ?>" required>
                
                <label for="altura">Altura (cm):</label>
                <input type="number" step="0.01" name="altura" id="altura" value="<?php echo htmlspecialchars($usuario->getAltura()); ?>" required>
            <?php endif; ?>
            
            <?php if ($tipo == 'nutricionista'): ?>
                <label for="formacao">Formação:</label>
                <input type="text" name="formacao" id="formacao" value="<?php echo htmlspecialchars($usuario->getFormacao()); ?>" required>
                
                <label for="preco_consulta">Preço por consulta:</label>
                <input type="text" name="preco_consulta" id="preco_consulta" value="<?php echo htmlspecialchars($usuario->getPreco_consulta()); ?>" placeholder="Digite o preço (ex: 50,00)" required>
                
            <?php endif; ?>
            
            <label for="senha">Nova Senha (opcional):</label>
            <input type="password" name="senha" id="senha" placeholder="Deixe em branco para manter">
            
            <button type="submit">Alterar</button>
        </form>
        
        <div class="logout">
            <a href="logout.php">Sair</a>
        </div>
    </div>
</body>
</html>
