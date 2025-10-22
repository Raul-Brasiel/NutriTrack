<?php
session_start();
	if(isset($_GET["fun"])){

		$fun = $_GET["fun"];
		
		if($fun == "cadastrar"){
			
			include_once("controle/Nutricionista/CadastrarNutricionista_class.php");
			$pag = new CadastrarNutricionista();
			
		} elseif($fun == "alterar"){
			include_once("controle/Nutricionista/AlterarNutricionista_class.php");
			$pag = new AlterarNutricionista();
			
		} elseif($fun == "excluir"){
			
			include_once("controle/Nutricionista/ExcluirNutricionista_class.php");//op == sim
			$pag = new ExcluirNutricionista();
			
		} elseif($fun == "listar"){
			include_once("controle/Nutricionista/ListarNutricionista_class.php");
			$pag = new ListarNutricionista();
			
		}  elseif($fun == "exibir") {
			include_once("controle/Nutricionista/ExibirNutricionista_class.php");
			$pag = new ExibirContato();
			
		} else {
			include_once("controle/Nutricionista/ListarNutricionista_class.php");
			$pag = new ListarNutricionista();			
		}
			
	} else {
		include_once("controle/Nutricionista/ListarNutricionista_class.php");
		$pag = new ListarNutricionista();
	}
?>
