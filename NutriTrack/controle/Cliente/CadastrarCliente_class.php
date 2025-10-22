<?php
include_once("modelo/Cliente/ClienteDAO_class.php");

class CadastrarCliente {
    public function __construct() {        
        if (isset($_POST["enviar"])) {
            // Verifica se email e senha estão na sessão (do primeiro formulário)
            if (!isset($_SESSION["email"]) || !isset($_SESSION["senha"])) {
                // Se não estiverem, redireciona ou mostra erro (evita acesso direto)
                die("Erro: Dados de login não encontrados. Complete o cadastro inicial primeiro.");
            }
            
            $c = new Cliente();
            $c->setNome($_POST["nome"]);
            $c->setIdade($_POST["idade"]);
            $peso = $_POST["peso"];
            $peso = trim(str_replace(",", ".", $peso)); // Remove espaços e troca vírgula por ponto
            $peso = number_format((float)$peso, 2, ".", ""); // Converte para número com duas casas decimais
            $c->setPeso($peso);
            $c->setAltura($_POST["altura"]);
            $c->setEmail($_SESSION["email"]); // Pega da sessão
            $c->setSenha($_SESSION["senha"]); // Pega da sessão (já hashada)
            
            // ---- FOTO ----
            $caminhoFoto = null;
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                // Cria pasta se não existir
                $pasta = __DIR__ . "/../../uploads/clientes/";
                if (!is_dir($pasta)) {
                    mkdir($pasta, 0777, true);
                }

                $nomeArquivo = uniqid() . "_" . basename($_FILES['foto']['name']);
                $caminhoRelativo = "uploads/clientes/" . $nomeArquivo; // Caminho salvo no banco
                $caminhoAbsoluto = $pasta . $nomeArquivo;

                move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoAbsoluto);
                $caminhoFoto = $caminhoRelativo;
            } else {
                // Se o usuário não enviou foto, usa a imagem padrão
                $caminhoFoto = "uploads/clientes/default.png";
            }
            $c->setFoto($caminhoFoto);

            $dao = new ClienteDAO();
            $dao->cadastrar($c);
            
            // Limpa as sessões após o cadastro para segurança
            unset($_SESSION["email"]);
            unset($_SESSION["senha"]);
            
            $status = "Cadastro do Cliente " . $c->getNome() . " efetuado com sucesso";
            $lista = $dao->listar();
            header("Location: /NutriTrack/visao/login.php");
        } else {
            include_once(__DIR__ . "../../../visao/Cliente/formCadastroCliente.php");
        }
    }
}
?>