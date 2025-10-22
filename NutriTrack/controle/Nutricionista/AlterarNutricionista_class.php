<?php
    // Definir raiz para includes
    define('ROOT_PATH', __DIR__ . '/../../');

    include_once(ROOT_PATH . "modelo/Nutricionista/NutricionistaDAO.php");
    include_once(ROOT_PATH . "modelo/Nutricionista/Nutricionista_class.php");

    class AlterarNutricionista {
        public function __construct() {
            // Verificar sessão (segurança: só o nutricionista logado pode alterar)
            session_start();
            if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 'nutricionista') {
                header("Location: ../../visao/login.php");
                exit;
            }

            if (isset($_POST["enviar"])) {
                // Formulário de alteração foi enviado
                $c = new Nutricionista_class();
                $c->setId($_POST["id"]);
                $c->setNome($_POST["nome"]);
                $c->setFormacao($_POST["formacao"]);
                $c->setNome($_POST["preco_consulta"]);
                $c->setFoto($_POST["foto"]);
                $c->setEmail($_POST["email"]);
                if (!empty($_POST["senha"])) {
                    $c->setSenha(password_hash($_POST["senha"], PASSWORD_DEFAULT));  // Hash da senha se fornecida
                }

                $dao = new NutricionistaDAO();
                $dao->alterar($c);

                // Redirecionar para dashboard
                header("Location: ../../visao/dashboard.php?status=" . urlencode($status));
                exit;

            } else {
                // Se não POST, buscar nutricionista por ID (GET) e incluir formulário
                $dao = new NutricionistaDAO();
                $nutricionista = $dao->buscarPorId($_GET["id"]);

                // Verificar se o ID corresponde ao usuário logado
                if ($nutricionista->getId() != $_SESSION['id']) {
                    echo "Acesso negado.";
                    exit;
                }

                //include_once("../../visao/Nutricionista/FormAlterarNutricionista.php");  // Formulário de alteração
            }
        }
    }

    // Instanciar a classe
    new AlterarNutricionista();
?>