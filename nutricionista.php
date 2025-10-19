<?php
session_start();
include_once("visao/topo.php");
	if(isset($_GET["fun"])){

		$fun = $_GET["fun"];
		
		if($fun == "cadastrar"){
			
			include_once("controle/CadastrarNutricionista_class.php");
			$pag = new CadastrarNutricionista();
			
		} elseif($fun == "alterar"){
			include_once("controle/AlterarNutricionista_class.php");
			$pag = new AlterarNutricionista();
			
		} elseif($fun == "excluir"){
			
			include_once("controle/ExcluirNutricionista_class.php");//op == sim
			$pag = new ExcluirNutricionista();
			
		} elseif($fun == "listar"){
			include_once("controle/ListarNutricionista_class.php");
			$pag = new ListarNutricionista();
			
		}  elseif($fun == "exibir") {
			include_once("controle/ExibirNutricionista_class.php");
			$pag = new ExibirContato();
			
		} else {
			include_once("controle/ListarNutricionista_class.php");
			$pag = new ListarNutricionista();			
		}
			
	} else {
		include_once("controle/ListarNutricionista_class.php");
		$pag = new ListarNutricionista();
	}
	
include_once("visao/base.php");

?>
