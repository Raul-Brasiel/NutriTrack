<?php
    class Nutricionista{
        private $id;
        private $nome;
        private $formacao;
        private $email;
        private $preco_consulta;
		private $senha;
		private $foto;

        public function __construct(){
		}		
		public function setId($id){
			$this->id = $id;
		}
		public function getId(){
			return $this->id;
		}

        public function getNome(){
			return $this->nome;
		}
		public function setNome($n){
			$this->nome = $n;
		}
		
        public function getFormacao(){
            return $this->formacao;
        }
        public function setFormacao($formacao){
            $this->formacao = $formacao;
        }

		public function getEmail(){
			return $this->email;
		}
		public function setEmail($email){
			$this->email = $email;
		}
        
        public function getPreco_consulta(){
			return $this->preco_consulta;
		}
		public function setPreco_consulta($preco){
			$this->preco_consulta = $preco;
		}
		public function getSenha(){
			return $this->senha;
		}
		public function setSenha($senha){
			$this->senha = $senha;
		}

		public function getFoto(){
			return $this->foto;
		}
		public function setFoto($foto){
			$this->foto = $foto;
		}

		public function verificarSenha($senha) {
			// Compara a senha fornecida com a senha hashed armazenada
			return password_verify($senha, $this->senha);  // $this->senha é a senha hashed do banco
		}
    }
?>