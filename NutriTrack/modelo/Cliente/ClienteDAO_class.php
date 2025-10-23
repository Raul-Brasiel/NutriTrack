<?php
    include_once(__DIR__ . "/../ConnectionFactory.php");//PDO
	include_once("Cliente_class.php"); //entidade
	
	class ClienteDAO{
        public $con = null; //obj recebe conexão
		
		public function __construct(){
			$conF = new ConnectionFactory();
			$this->con = $conF->getConnection();
		}

		public function cadastrar($cont){
			try{
				$stmt = $this->con->prepare(
				"INSERT INTO cliente(nome, idade, peso, altura, email, senha, foto)
				VALUES (:nome, :idade, :peso, :altura, :email, :senha, :foto)");
				//:nome - é uma âncora e será ligado pelo bindValue
				//SQL injection
				//ligamos as âncoras aos valores de Contato
				$stmt->bindValue(":nome", $cont->getNome());
				$stmt->bindValue(":idade", $cont->getIdade());
                $stmt->bindValue(":peso", $cont->getPeso());
                $stmt->bindValue(":altura", $cont->getAltura());
				$stmt->bindValue(":email", $cont->getEmail());
				$stmt->bindValue(":senha", $cont->getSenha());
				$stmt->bindValue(":foto", $cont->getFoto());
				
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
					$dados = $this->con->query("SELECT * FROM cliente");
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
					$c = new Cliente();
					$c->setId($linha["id"]);
					$c->setNome($linha["nome"]);
					$c->setIdade($linha["idade"]);
                    $c->setPeso($linha["peso"]);
                    $c->setAltura($linha["altura"]);
					$c->setEmail($linha["email"]);
                    $c->setSenha($linha["senha"]);
					$c->setFoto($linha["foto"]);
					$lista[] = $c;
				}
				return $lista;	
			}
			catch(PDOException $ex){
				echo "Erro: " . $ex->getMessage();
			}
		}

		public function alterar($cont){
			try{
				$stmt = $this->con->prepare(
				"UPDATE cliente SET nome=:nome, email = :email, idade=:idade, peso=:peso, altura=:altura, senha=:senha 
				WHERE id=:id");
				
				//ligamos as âncoras aos valores de Contato
				$stmt->bindValue(":nome", $cont->getNome());
				$stmt->bindValue(":email", $cont->getEmail());
				$stmt->bindValue(":idade", $cont->getIdade());
				$stmt->bindValue(":peso", $cont->getPeso());
				$stmt->bindValue(":altura", $cont->getAltura());
				$stmt->bindValue(":senha", $cont->getSenha());
				$stmt->bindValue(":foto", $cont->getFoto());
				$stmt->bindValue(":id", $cont->getId());
				
				$this->con->beginTransaction();
			    $stmt->execute(); //execução do SQL	
				$this->con->commit(); 
				/*$this->con->close();
				$this->con = null;*/	
			}
			catch(PDOException $ex){
				echo "Erro: " . $ex->getMessage();
			}
		}

		public function buscarPorEmail($email) {
            $stmt = $this->con->prepare("SELECT id, email, senha FROM cliente WHERE email = ?");  // Corrigido: $this->con em vez de $con
            $stmt->execute([$email]);
            $linha = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($linha) {
                // Retorna um objeto Cliente preenchido
                $cliente = new Cliente();  // Ajuste para Cliente_class se sua classe for nomeada assim
                $cliente->setId($linha['id']);
                $cliente->setEmail($linha['email']);
                $cliente->setSenha($linha['senha']);  // Senha hashed
				$cliente->setFoto($linha['foto']);
                return $cliente;
            }
            return null;  // Não encontrado
        }

        public function buscarPorId($id) {
            $stmt = $this->con->prepare("SELECT id, nome, idade, peso, altura, email, senha, foto FROM cliente WHERE id = ?");
            $stmt->execute([$id]);
            $linha = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($linha) {
                // Retorna um objeto Cliente preenchido
                $cliente = new Cliente();
                $cliente->setId($linha['id']);
                $cliente->setNome($linha['nome']);
                $cliente->setIdade($linha['idade']);
                $cliente->setPeso($linha['peso']);
                $cliente->setAltura($linha['altura']);
                $cliente->setEmail($linha['email']);
                $cliente->setSenha($linha['senha']);  // Senha hashed
				$cliente->setFoto($linha['foto']);
                return $cliente;
            }
            return null;  // Não encontrado
        }
    }
?>