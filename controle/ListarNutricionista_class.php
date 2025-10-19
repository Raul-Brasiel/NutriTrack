<?php
	include_once("modelo/NutricionistaDAO_class.php");
	
	class ListarNutricionista{
	
		public function __construct(){
			$dao = new NutricionistaDAO();
			$lista = $dao->listar();
			//array de objetos do tipo nutricionista
			
			include_once("visao/listaNutricionista.php");		
		}
	}
?>

