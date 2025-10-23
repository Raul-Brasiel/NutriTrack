<?php
    // Definir raiz para includes
    define('ROOT_PATH', __DIR__ . '/../../');

    include_once(ROOT_PATH . "modelo/Cliente/ClienteDAO.php");
    include_once(ROOT_PATH . "modelo/Cliente/Cliente_class.php");

    class AlterarCliente {
        public function __construct() {
            // Verificar sessão (segurança: só o cliente logado pode alterar)
            session_start();
            if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 'cliente') {
                header("Location: ../../visao/login.php");
                exit;
            }

            if (isset($_POST["enviar"])) {
                // Formulário de alteração foi enviado
                $c = new Cliente();
                $c->setId($_POST["id"]);
                $c->setNome($_POST["nome"]);
                $c->setIdade($_POST["idade"]);
                $c->setPeso($_POST["peso"]);
                $c->setAltura($_POST["altura"]);
                $c->setFoto($_POST["foto"]);
                $c->setEmail($_POST["email"]);
                if (!empty($_POST["senha"])) {
                    $c->setSenha(password_hash($_POST["senha"], PASSWORD_DEFAULT));  // Hash da senha se fornecida
                }

                $dao = new ClienteDAO();
                $dao->alterar($c);

                // Redirecionar para dashboard
                header("Location: ../../visao/dashboard.php?status=" . urlencode($status));
                exit;

            } else {
                // Se não POST, buscar cliente por ID (GET) e incluir formulário
                $dao = new ClienteDAO();
                $cliente = $dao->buscarPorId($_GET["id"]);

                // Verificar se o ID corresponde ao usuário logado
                if ($cliente->getId() != $_SESSION['id']) {
                    echo "Acesso negado.";
                    exit;
                }

                //include_once("../../visao/Cliente/FormAlterarCliente.php");  // Formulário de alteração
            }
        }
    }

    // Instanciar a classe
    new AlterarCliente();
?>