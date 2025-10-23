<?php
	include_once("modelo/Nutricionista/NutricionistaDAO_class.php");
	
	class ListarNutricionista{
	
		public function __construct(){
			$dao = new NutricionistaDAO();
			$lista = $dao->listar();
			//array de objetos do tipo nutricionista
			
			include_once(__DIR__ . "../../../visao/Nutricionista/listaNutricionista.php");		
		}
	}
?>

