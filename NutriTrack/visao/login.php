<?php
// Iniciar sessão para armazenar dados do usuário logado
session_start();
define('ROOT_PATH', dirname(__DIR__) . '/');
// Incluir as classes necessárias (ajuste os caminhos conforme sua estrutura de pastas)
require_once ROOT_PATH . 'modelo/ConnectionFactory.php';
require_once ROOT_PATH . 'modelo/Nutricionista/NutricionistaDAO_class.php';
require_once ROOT_PATH . 'modelo/Cliente/ClienteDAO_class.php';
require_once ROOT_PATH . 'modelo/Nutricionista/Nutricionista_class.php';
require_once ROOT_PATH . 'modelo/Cliente/Cliente_class.php';
// Processar o formulário se enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo = $_POST['tipo'];
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    // Instanciar o DAO correto baseado no tipo
    if ($tipo == 'nutricionista') {
        $dao = new NutricionistaDAO();
    } elseif ($tipo == 'cliente') {
        $dao = new ClienteDAO();
    } else {
        $erro = "Tipo de usuário inválido.";
    }

    if (!isset($erro)) {
        // Buscar usuário pelo email
        $usuario = $dao->buscarPorEmail($email);

        if ($usuario && $usuario->verificarSenha($senha)) {
            // Login bem-sucedido: armazenar na sessão e redirecionar
            $_SESSION['id'] = $usuario->getId();  // Assumindo getter para id
            $_SESSION['tipo'] = $tipo;
            header("Location: dashboard.php"); // Página após login (crie conforme necessário)
            exit;
        } else {
            $erro = "Email ou senha incorretos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body { 
            font-family: "Poppins", sans-serif;
            background: url('https://greenlifeacademias.com.br/wp/wp-content/uploads/2023/02/1-2.jpg') no-repeat center/cover;
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0;
        }
        .fundo {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(10px);
            background-color: rgba(0, 0, 0, 0.3); /* escurece um pouco */
            z-index: 1;
        }
        .login-container { 
            background: white; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); 
            width: 350px;
            position: relative;
            z-index: 2;
        }
        h2 { 
            text-align: center; 
        }
        label { 
            display: block; 
            margin-bottom: 5px; 
        }
        select, input { 
            padding: 8px;
            width: 100%; 
            margin-bottom: 15px; 
            border: 1px solid #ccc; 
            border-radius: 4px;
            box-sizing: border-box;
        }
        button { 
            width: 100%; 
            padding: 10px; 
            background-color: #4CAF50; 
            color: white; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; }
        button:hover { 
            background-color: #45a049; 
        }
        .erro { 
            color: red; 
            text-align: center; 
            margin-bottom: 15px; 
        }
        .cadastro { 
            text-align: center; 
            margin-top: 15px; 
        }
        .cadastro a { 
            color: #007BFF; 
            text-decoration: none; 
        }
    </style>
</head>
<body>
    <div class="fundo"></div>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($erro)) echo "<p class='erro'>$erro</p>"; ?>
        <form method="POST">
            <label for="tipo">Tipo de usuário:</label>
            <select name="tipo" id="tipo" required>
                <option value="">Selecione</option>
                <option value="nutricionista">Nutricionista</option>
                <option value="cliente">Cliente</option>
            </select>
            
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="ex: email.exemplo@gmail.com" required>
            
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" placeholder="digite sua senha" required>
            
            <button type="submit">Entrar</button>
        </form>
        <div class="cadastro">
            <p>Não tem uma conta? <a href="../cliente.php?fun=cadastrar">Cadastre-se</a></p>
            <p>Faça parte da nossa equipe: <a href="../nutricionista.php?fun=cadastrar">Cadastre-se</a></p>
        </div>
    </div>
</body>
</html>