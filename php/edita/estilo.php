<?php

    session_start(); 

    include_once("../../conn/conn.php");  

	$_SESSION['estilo'] = ($_SESSION['estilo'] == 1) ? 2 : 1;

	if(!empty($_SESSION['estilo']) and !empty($_SESSION['id_pessoa']))
	{
		$sql  = "UPDATE pessoa SET estilo = ? WHERE id_pessoa = ? ";

		$stmt = mysqli_prepare($conn, $sql);

		mysqli_stmt_bind_param($stmt, "ii", $_SESSION['estilo'], $_SESSION['id_pessoa']);

		mysqli_stmt_execute($stmt);

		// Verifica se a atualização foi bem-sucedida
		if (mysqli_stmt_affected_rows($stmt) > 0) 
        {
			echo "Alterado com sucesso!";
		}
	}

?>