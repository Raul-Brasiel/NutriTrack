<?php
session_start();
	if(isset($_GET["fun"])){

		$fun = $_GET["fun"];
		
		if($fun == "cadastrar"){
			
			include_once("controle/Cliente/CadastrarCliente_class.php");
			$pag = new CadastrarCliente();
			
		} elseif($fun == "alterar"){
			include_once("controle/Cliente/AlterarCliente_class.php");
			$pag = new AlterarCliente();
			
		} elseif($fun == "excluir"){
			
			include_once("controle/Cliente/ExcluirCliente_class.php");//op == sim
			$pag = new ExcluirCliente();
			
		} elseif($fun == "listar"){
			include_once("controle/Cliente/ListarCliente_class.php");
			$pag = new ListarCliente();
			
		}  elseif($fun == "exibir") {
			include_once("controle/Cliente/ExibirCliente_class.php");
			$pag = new ExibirCliente();
			
		} else {
			include_once("controle/Cliente/ListarCliente_class.php");
			$pag = new ListarCliente();			
		}
			
	} else {
		include_once("controle/Cliente/ListarCliente_class.php");
		$pag = new ListarCliente();
	}
?>