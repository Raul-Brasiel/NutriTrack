<?php

	include_once("modelo/NutricionistaDAO_class.php");
	
	class ExibirNutricionista{
	
		public function __construct(){
			
			$dao = new NutricionistaDAO();
			$cont = $dao->exibir($_GET["id"]);
			include_once("visao/exibeNutricionista.php");	
			
		}
	}

?>