<?php
$mostrar_primeiro_form = true; // Por padrão, mostra o primeiro formulário
$erro = ''; // Para mensagens de erro

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    // Processa o primeiro formulário
    $email = trim($_POST['email']);
    $senha1 = $_POST['senha1'];
    $senha2 = $_POST['senha2'];
    
    // Validações básicas
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Email inválido.';
    } elseif (empty($senha1) || empty($senha2)) {
        $erro = 'Preencha ambas as senhas.';
    } elseif ($senha1 !== $senha2) {
        $erro = 'As senhas não coincidem.';
    } elseif (strlen($senha1) < 6) {
        $erro = 'A senha deve ter pelo menos 6 caracteres.';
    } else {
        // Sucesso: mostra o segundo formulário
        $mostrar_primeiro_form = false;
        // Armazena temporariamente os dados na sessão
        $_SESSION['email'] = $email;
        $_SESSION['senha'] = password_hash($senha1, PASSWORD_DEFAULT); // Hash da senha para segurança
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Cadastrar Cliente</title>
    <meta charset="UTF-8">
    <style>
        body{
            font-family: "Poppins", sans-serif;
            background: #f0f0f0ff;
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
        }

        .section_cliente {
            background: white; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); 
            width: 350px;
            position: relative;
        }

        .main_cliente h1,h2 {
            color: #4caf50;
            text-align: center;
        }

        .form_cadastroCliente,.form_login {
            display: flex;
            flex-direction: column;
        }

        .label_dado_cliente,.label_login {
            margin-top: 10px;
            font-weight: bold;
        }

        .campo_cliente,.campo_login {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .button_enviar {
            margin-top: 20px;
            padding: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .button_enviar:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        // JavaScript para verificar se as senhas são iguais antes de enviar
        function verificarSenhas() {
            const senha1 = document.getElementById('senha1').value;
            const senha2 = document.getElementById('senha2').value;
            if (senha1 !== senha2) {
                alert('As senhas não coincidem. Por favor, verifique.');
                return false; // Impede o envio
            }
            return true; // Permite o envio
        }
    </script>
</head>
<body>
    <main class="main_cliente">
        <section class="section_cliente">
            <?php if ($mostrar_primeiro_form): ?>
                <!-- Primeiro formulário: Email e Senha -->
                <h2>Cadastro Inicial</h2>
                <form class="form_login" action="cliente.php?fun=cadastrar" method="POST" onsubmit="return verificarSenhas();" enctype="multipart/form-data">
                    <label class="label_login" for="email">Email:</label>
                    <input class="campo_login" type="email" id="email" name="email" placeholder="Digite seu email" required>
                    
                    <label class="label_login" for="senha1">Senha:</label>
                    <input class="campo_login" type="password" id="senha1" name="senha1" placeholder="Digite sua senha" required>
                    
                    <label class="label_login" for="senha2">Confirme a Senha:</label>
                    <input class="campo_login" type="password" id="senha2" name="senha2" placeholder="Digite novamente sua senha" required>
                    
                    <input type="submit" name="proximo" value="Próximo" class="button_enviar">
                </form>
                <?php if ($erro): ?>
                    <p class="erro"><?php echo $erro; ?></p>
                <?php endif; ?>
            <?php else: ?>
                <!-- Segundo formulário: Dados do Cliente -->
                <h2>Cadastro de Dados</h2>
                <form class="form_cadastroCliente" action="cliente.php?fun=cadastrar" method="POST" enctype="multipart/form-data">
                    <label class="label_dado_cliente" for="nome">Nome:</label>
                    <input class="campo_cliente" type="text" id="nome" name="nome" placeholder="Digite seu nome" required>

                    <label class="label_dado_cliente" for="idade">Idade:</label>
                    <input class="campo_cliente" type="number" id="idade" name="idade" placeholder="Digite sua idade" required>

                    <label class="label_dado_cliente" for="peso">Peso:</label>
                    <input class="campo_cliente" type="text" id="peso" name="peso" placeholder="Digite seu peso (ex: 74,50)" required>

                    <label class="label_dado_cliente" for="nome">Altura:</label>
                    <input class="campo_cliente" type="number" id="altura" name="altura" placeholder="Digite sua altura em cm" required>
                    
                    <label class="label_dado_cliente" for="foto">Foto:</label>
                    <input class="campo_cliente" type="file" name="foto" accept="image/*" style="border: none;margin:0;padding:0;">

                    <input type="submit" name="enviar" value="Enviar" class="button_enviar">
                </form>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>