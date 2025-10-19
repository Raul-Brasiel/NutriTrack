<?php
	include_once("ConnectionFactory.php");//PDO
	include_once("Nutricionista_class.php"); //entidade
	
	class NutricionistaDAO{
        public $con = null; //obj recebe conexão
		
		public function __construct(){
			$conF = new ConnectionFactory();
			$this->con = $conF->getConnection();
		}

		public function cadastrar($cont){
			try{
				$stmt = $this->con->prepare(
				"INSERT INTO nutricionista(nome, formacao, email, preco_consulta, senha)
				VALUES (:nome, :formacao, :email, :preco_consulta, :senha)");
				//:nome - é uma âncora e será ligado pelo bindValue
				//SQL injection
				//ligamos as âncoras aos valores de Contato
				$stmt->bindValue(":nome", $cont->getNome());
				$stmt->bindValue(":formacao", $cont->getFormacao());
				$stmt->bindValue(":email", $cont->getEmail());
				$stmt->bindValue(":preco_consulta", $cont->getPreco_consulta());
				$stmt->bindValue(":senha", $cont->getSenha());
				
				$stmt->execute(); //execução do SQL	
				/*$this->con->close();
				$this->con = null;*/	
			}
			catch(PDOException $ex){
				echo "Erro: " . $ex->getMessage();
			}
		}

        public function listar($query = null){		
			//se não recebe parâmetro (ou seja, uma consulto personalizada)
			//$query recebe nulo
			try{
				if($query == null){
					$dados = $this->con->query("SELECT * FROM nutricionista");
					//dataset (conjunto de dados) com todos os dados
					//query() é função PDO, executa SQL
				} else {
					$dados = $this->con->query($query);
					//se listar receber parâmetro este será uma SQL 
					//SQL específica
				}
				$lista = array(); //crio chamando função array()

				/*for($i = 0; $i<$dados.lenght; $i++){
					$c->setNome($dados[i][1]);
				}*/

				foreach($dados as $linha){
				//percorre linha a linha de dados e coloca cada registro
				//na variável linha (que é um vetor)
					$c = new Nutricionista();
					$c->setId($linha["id"]);
					$c->setNome($linha["nome"]);
					$c->setFormacao($linha["formacao"]);
					$c->setEmail($linha["email"]);
                    $c->setPreco_consulta($linha["preco_consulta"]);
					$lista[] = $c;
				}
				return $lista;	
			}
			catch(PDOException $ex){
				echo "Erro: " . $ex->getMessage();
			}
		}

		
    }
?>