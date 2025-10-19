<?php
include_once("modelo/NutricionistaDAO_class.php");

class CadastrarNutricionista {
    public function __construct() {        
        if (isset($_POST["enviar"])) {
            // Verifica se email e senha estão na sessão (do primeiro formulário)
            if (!isset($_SESSION["email"]) || !isset($_SESSION["senha"])) {
                // Se não estiverem, redireciona ou mostra erro (evita acesso direto)
                die("Erro: Dados de login não encontrados. Complete o cadastro inicial primeiro.");
            }
            
            $c = new Nutricionista();
            $c->setNome($_POST["nome"]);
            $c->setFormacao($_POST["formacao"]);
            $c->setEmail($_SESSION["email"]); // Pega da sessão
            $preco = $_POST["preco_consulta"];
            $preco = trim(str_replace(",", ".", $preco)); // Remove espaços e troca vírgula por ponto
            $preco = number_format((float)$preco, 2, ".", ""); // Converte para número com duas casas decimais
            $c->setPreco_consulta($preco);
            $c->setSenha($_SESSION["senha"]); // Pega da sessão (já hashada)
            
            $dao = new NutricionistaDAO();
            $dao->cadastrar($c);
            
            // Limpa as sessões após o cadastro para segurança
            unset($_SESSION["email"]);
            unset($_SESSION["senha"]);
            
            $status = "Cadastro do Nutricionista " . $c->getNome() . " efetuado com sucesso";
            $lista = $dao->listar();
            include_once("visao/listaNutricionista.php");
        } else {
            include_once("visao/formCadastroNutricionista.php");
        }
    }
}
?>