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
    <title>Cadastrar Nutricionista</title>
    <meta charset="UTF-8">
    <style>
        body { 
            font-family: "Poppins", sans-serif;
            background: #ebebebff;
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0;
        }
        .main_nutricionistas {
            display: flex;
            justify-content: center;
            padding: 20px;
            flex-wrap: wrap;
        }

        .section_nutricionistas {
            background: white; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); 
            width: 350px;
            position: relative;
            z-index: 2;
        }

        .main_nutricionistas h1,h2 {
            color: #4caf50;
            text-align: center;
        }

        .form_cadastroNutricionista,.form_login {
            display: flex;
            flex-direction: column;
        }

        .label_dado_nutricionista,.label_login {
            margin-top: 10px;
            font-weight: bold;
        }

        .campo_nutricionista,.campo_login {
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

        .erro {
            color: red;
            margin-top: 10px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .section_nutricionistas {
                width: 90%;
            }
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
    <main class="main_nutricionistas">
        <section class="section_nutricionistas">
            <?php if ($mostrar_primeiro_form): ?>
                <!-- Primeiro formulário: Email e Senha -->
                <h2>Cadastrar para Nutricionista</h2>
                <form class="form_login" action="nutricionista.php?fun=cadastrar" method="POST" onsubmit="return verificarSenhas();" enctype="multipart/form-data">
                    <label class="label_login" for="email">Email:</label>
                    <input class="campo_login" type="email" id="email" name="email" placeholder="Digite seu email" required>
                    
                    <label class="label_login" for="senha1">Senha:</label>
                    <input class="campo_login" type="password" id="senha1" name="senha1" placeholder="Digite sua senha" required>
                    
                    <label class="label_login" for="senha2">Confirme a Senha:</label>
                    <input class="campo_login" type="password" id="senha2" name="senha2" placeholder="Digite novamente sua senha" required>
                    
                    <input type="submit" name="proximo" value="Próximo" class="button_enviar"> <!-- Mudei o name para "proximo" para diferenciar -->
                </form>
                <?php if ($erro): ?>
                    <p class="erro"><?php echo $erro; ?></p>
                <?php endif; ?>
            <?php else: ?>
                <!-- Segundo formulário: Dados do Nutricionista -->
                <h2>Cadastro de Dados</h2>
                <form class="form_cadastroNutricionista" action="nutricionista.php?fun=cadastrar" method="POST" enctype="multipart/form-data">
                    <label class="label_dado_nutricionista" for="nome">Nome:</label>
                    <input class="campo_nutricionista" type="text" id="nome" name="nome" placeholder="Digite seu nome completo" required>
                    
                    <label class="label_dado_nutricionista" for="formacao">Formação:</label>
                    <input class="campo_nutricionista" type="text" id="formacao" name="formacao" placeholder="Digite sua formação acadêmica" required>
                    
                    <label class="label_dado_nutricionista" for="preco_consulta">Preço de Consulta:</label>
                    <input class="campo_nutricionista" type="text" id="preco_consulta" name="preco_consulta" placeholder="Digite o preço (ex: 50,00)" required>
                    
                    <label class="label_dado_nutricionista" for="foto">Foto:</label>
                    <input class="campo_nutricionista" type="file" name="foto" accept="image/*" style="border: none;margin:0;padding:0;">

                    <input type="submit" name="enviar" value="Enviar" class="button_enviar">
                </form>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>