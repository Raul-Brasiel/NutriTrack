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
                $dao = new NutricionistaDAO();
                $fotoAtual = $dao->buscarPorId($_POST["id"])->getFoto();

                $c = new Nutricionista_class();
                $c->setId($_POST["id"]);
                $c->setNome($_POST["nome"]);
                $c->setFormacao($_POST["formacao"]);
                $c->setPreco_consulta($_POST["preco_consulta"]);
                $c->setEmail($_POST["email"]);
                if (!empty($_POST["senha"])) {
                    $c->setSenha(password_hash($_POST["senha"], PASSWORD_DEFAULT));  // Hash da senha se fornecida
                }

                $caminhoFoto = null;

                if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                    // Cria pasta se não existir
                    $pasta = __DIR__ . "/../../uploads/nutricionistas/";
                    if (!is_dir($pasta)) {
                        mkdir($pasta, 0777, true);
                    }

                    $nomeArquivo = uniqid() . "_" . basename($_FILES['foto']['name']);
                    $caminhoRelativo = "uploads/nutricionistas/" . $nomeArquivo; // Caminho salvo no banco
                    $caminhoAbsoluto = $pasta . $nomeArquivo;

                    move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoAbsoluto);
                    $caminhoFoto = $caminhoRelativo;
                } else {
                    // Se o usuário não enviou foto, usa a imagem padrão
                    $caminhoFoto = $fotoAtual;
                }

                $c->setFoto($caminhoFoto);

                
                $dao->alterar($c);

                // Redirecionar para dashboard
                header("Location: ../../visao/dashboard.php?status=ok");
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