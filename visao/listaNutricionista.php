<HTML>
	<HEAD>
		<TITLE> Listagem de Nutricionistas </TITLE>
		<META charset="UTF-8" />
		<style>
			h1 {
				text-align: center;
				color: #4CAF50;
				margin: 3% 0;
			}
			.nutricionista {
				display: flex;
				flex-direction: column;
				background-color: #fff;
				margin: 1% 20%;
				padding: 20px;
				border-radius: 8px;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
				align-items: center;
			}
			.foto {
				margin-bottom: 15px;
			}
			.foto img {
				width: 120px;
				height: 120px;
				object-fit: cover;
				border-radius: 50%;
			}
			.info {
				text-align: center;
				margin-bottom: 15px;
			}
			.info h3 {
				margin: 0 0 10px 0;
				color: #2c3e50;
			}
			.info p {
				margin: 5px 0;
			}
			.button-container {
				text-align: center;
			}
			.button {
				display: inline-block;
				padding: 10px 20px;
				background-color: #27ae60;
				color: white;
				text-decoration: none;
				border-radius: 4px;
			}
			.button:hover {
				background-color: #229954;
			}
			.button-Cadastrar{
				text-align: center;
			}
			.button-Cadastrar a{
				padding: 10px 20px;
				background-color: #2795aeff;
				border-radius: 4px;
				text-decoration: none;
				color: white;
			}
		</style>
	</HEAD>
	<body>
		<h1>Listagem de Nutricionistas Disponíveis</h1>
		<?php
			if(isset($status)){ echo "<h2>".$status."</h2>";}
			// Se $status está preenchida, imprimir ela
		?>
		<table>
			
			
			<?php
				foreach($lista as $c){    
					echo "<div class='nutricionista'>";
					
					echo "<div class='foto'><img src='" . "imagem aqui" . "' alt='Foto de " . $c->getNome() . "' /></div>";
					
					echo "<div class='info'>";
					echo "<h3>" . $c->getNome() . "</h3>";
					echo "<p>" . $c->getFormacao() . "</p>";
					echo "<p><strong>E-mail:</strong> " . $c->getEmail() . "</p>";
					echo "<p><strong>Preço por Consulta:</strong> R$" . number_format($c->getPreco_consulta(), 2, ',', '.') . "</p>";
					echo "</div>";
					
					// Botão centralizado
					echo "<div class='button-container'>";
					echo "<a href='mailto:" . $c->getEmail() . "' class='button'>Entrar em Contato</a>";
					echo "</div>";
					
					echo "</div>";
				} 
			?>   
		</table>
		
		<div class="button-Cadastrar"><a href="nutricionista.php?fun=cadastrar">Faça parte do nosso time</a></div>
	</body>
</HTML>