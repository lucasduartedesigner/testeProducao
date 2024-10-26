<?php 

	//Inclui os arquivos externos de scripts javascript
	include_once("{$raiz}template/js/scripts.php");

	//Inclui as funções javascript
	include_once("{$raiz}template/js/functions.php"); 

	//Inclui as chamadas de auto complete 
	include_once("{$raiz}template/js/autocomplete.php");

	//Inclui as operações principais
	include_once("{$raiz}template/js/main.php");

	//Inclui as chamadas de mudança
	include("{$raiz}template/js/change.php");

	//Inclui modal de senha quando tiver reset senha no perfil
	if(!empty($_SESSION['reset']) == true)
	{
		include_once("{$raiz}modal/senha.php");

		echo "<script> $(window).on('load', function(){ $('#modal-senha').modal('show') }) </script>";
	}

?>