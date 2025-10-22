<?php
include_once("modelo/Nutricionista/NutricionistaDAO_class.php");

class CadastrarNutricionista {
    public function __construct() {        
        if (isset($_POST["enviar"])) {
            // Verifica se email e senha estão na sessão
            if (!isset($_SESSION["email"]) || !isset($_SESSION["senha"])) {
                die("Erro: Dados de login não encontrados. Complete o cadastro inicial primeiro.");
            }

            $c = new Nutricionista();
            $c->setNome($_POST["nome"]);
            $c->setFormacao($_POST["formacao"]);
            $c->setEmail($_SESSION["email"]); 
            $preco = $_POST["preco_consulta"];
            $preco = trim(str_replace(",", ".", $preco)); 
            $preco = number_format((float)$preco, 2, ".", ""); 
            $c->setPreco_consulta($preco);
            $c->setSenha($_SESSION["senha"]); 

            // ---- FOTO ----
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
                $caminhoFoto = "uploads/nutricionistas/default.png";
            }

            $c->setFoto($caminhoFoto);
            // ---- CADASTRA ----
            $dao = new NutricionistaDAO();
            $dao->cadastrar($c);

            unset($_SESSION["email"]);
            unset($_SESSION["senha"]);

            $status = "Cadastro do Nutricionista " . $c->getNome() . " efetuado com sucesso";
            $lista = $dao->listar();
            include_once(__DIR__ . "/../../visao/Nutricionista/listaNutricionista.php");
        } else {
            include_once(__DIR__ . "/../../visao/Nutricionista/formCadastroNutricionista.php");
        }
    }
}
?>