<?php
include_once(__DIR__ . "/../ConnectionFactory.php");
include_once("Nutricionista_class.php");

class NutricionistaDAO {
    public $con = null;

    public function __construct() {
        $conF = new ConnectionFactory();
        $this->con = $conF->getConnection();
    }

    public function cadastrar($cont) {
        try {
            $stmt = $this->con->prepare(
                "INSERT INTO nutricionista (nome, formacao, email, preco_consulta, senha, foto)
                 VALUES (:nome, :formacao, :email, :preco_consulta, :senha, :foto)"
            );

            $stmt->bindValue(":nome", $cont->getNome());
            $stmt->bindValue(":formacao", $cont->getFormacao());
            $stmt->bindValue(":email", $cont->getEmail());
            $stmt->bindValue(":preco_consulta", $cont->getPreco_consulta());
            $stmt->bindValue(":senha", $cont->getSenha());
            $stmt->bindValue(":foto", $cont->getFoto());

            $stmt->execute();
        } catch (PDOException $ex) {
            echo "Erro: " . $ex->getMessage();
        }
    }

    public function listar($query = null) {
        try {
            $dados = $query == null 
                ? $this->con->query("SELECT * FROM nutricionista") 
                : $this->con->query($query);

            $lista = array();
            foreach ($dados as $linha) {
                $c = new Nutricionista();
                $c->setId($linha["id"]);
                $c->setNome($linha["nome"]);
                $c->setFormacao($linha["formacao"]);
                $c->setEmail($linha["email"]);
                $c->setPreco_consulta($linha["preco_consulta"]);
                $c->setFoto($linha["foto"]);
                $lista[] = $c;
            }
            return $lista;
        } catch (PDOException $ex) {
            echo "Erro: " . $ex->getMessage();
        }
    }

    public function alterar($cont) {
        try {
            $stmt = $this->con->prepare(
                "UPDATE nutricionista 
                 SET nome=:nome, formacao=:formacao, preco_consulta=:preco_consulta, 
                     email=:email, senha=:senha, foto=:foto 
                 WHERE id=:id"
            );

            $stmt->bindValue(":nome", $cont->getNome());
            $stmt->bindValue(":formacao", $cont->getFormacao());
            $stmt->bindValue(":preco_consulta", $cont->getPreco_consulta());
            $stmt->bindValue(":email", $cont->getEmail());
            $stmt->bindValue(":senha", $cont->getSenha());
            $stmt->bindValue(":foto", $cont->getFoto());
            $stmt->bindValue(":id", $cont->getId());

            $this->con->beginTransaction();
            $stmt->execute();
            $this->con->commit();
        } catch (PDOException $ex) {
            echo "Erro: " . $ex->getMessage();
        }
    }

    public function buscarPorEmail($email) {
        $stmt = $this->con->prepare("SELECT id, email, senha, foto FROM nutricionista WHERE email = ?");
        $stmt->execute([$email]);
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($linha) {
            $nutricionista = new Nutricionista();
            $nutricionista->setId($linha['id']);
            $nutricionista->setEmail($linha['email']);
            $nutricionista->setSenha($linha['senha']);
            $nutricionista->setFoto($linha['foto']);
            return $nutricionista;
        }
        return null;
    }

    public function buscarPorId($id) {
        $stmt = $this->con->prepare("SELECT * FROM nutricionista WHERE id = ?");
        $stmt->execute([$id]);
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($linha) {
            $nutricionista = new Nutricionista();
            $nutricionista->setId($linha['id']);
            $nutricionista->setNome($linha['nome']);
            $nutricionista->setFormacao($linha['formacao']);
            $nutricionista->setPreco_consulta($linha['preco_consulta']);
            $nutricionista->setEmail($linha['email']);
            $nutricionista->setSenha($linha['senha']);
            $nutricionista->setFoto($linha['foto']);
            
            return $nutricionista;
        }
        return null;
    }
}
?>