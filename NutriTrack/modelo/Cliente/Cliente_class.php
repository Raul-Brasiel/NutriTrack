<?php
    class Cliente{
        private $id;
        private $nome;
        private $idade;
        private $peso;
        private $altura;
        private $email;
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

        public function getIdade(){
			return $this->idade;
		}
		public function setIdade($n){
			$this->idade = $n;
		}

        public function getPeso(){
			return $this->peso;
		}
		public function setPeso($n){
			$this->peso = $n;
		}

        public function getAltura(){
			return $this->altura;
		}
		public function setAltura($n){
			$this->altura = $n;
		}

		public function getEmail(){
			return $this->email;
		}
		public function setEmail($n){
			$this->email = $n;
		}

		public function getSenha(){
			return $this->senha;
		}
		public function setSenha($n){
			$this->senha = $n;
		}

		public function getFoto()
		{
			return $this->foto;
		}
		public function setFoto($foto)
		{
			$this->foto = $foto;
			
		}

		public function verificarSenha($senha) {
			// Compara a senha fornecida com a senha hashed armazenada
			return password_verify($senha, $this->senha);  // $this->senha é a senha hashed do banco
		}
    }
?>