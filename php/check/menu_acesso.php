<?php

    session_start(); 
   
    include_once("../../conn/conn.php");

	if (isset($_POST['id_nivel'], $_POST['id_menu'], $_POST['tipo'], $_POST['status'])) 
	{
		$id_nivel = $_POST['id_nivel'];
		$id_menu  = $_POST['id_menu'];
		$tipo     = $_POST['tipo'];
		$status   = $_POST['status'];

		switch ($tipo) 
		{
			case 'l':
				$tipo = "leitura";
				break;
			case 'e':
				$tipo = "editar";
				break;
			case 'd':
				$tipo = "deletar";
				break;
		}

		$sql = "SELECT * 
				FROM menu_acesso 
				WHERE id_nivel_acesso = ? 
				AND id_menu = ?";

		$stmt = mysqli_prepare($conn, $sql);

		mysqli_stmt_bind_param($stmt, "ii", $id_nivel, $id_menu);
		mysqli_stmt_execute($stmt);

		$result = mysqli_stmt_get_result($stmt);
		$row    = mysqli_fetch_assoc($result);

		$id = $row['id_menu_acesso'] ?? null;

		if (empty($id)) 
		{
			$sql = "INSERT INTO menu_acesso (id_nivel_acesso, id_menu, $tipo) 
					VALUES (?, ?, ?)";

			$stmt = mysqli_prepare($conn, $sql);

			mysqli_stmt_bind_param($stmt, "iii", $id_nivel, $id_menu, $status);

			if (mysqli_stmt_execute($stmt)) 
			{
				$id = mysqli_insert_id($conn);

				echo "Cadastrado com sucesso!";
			} 
			else 
			{
				echo "Problema ao cadastrar menu de acesso! " . mysqli_error($conn);
			}
		} 
		else 
		{
			$sql = "UPDATE menu_acesso
					SET $tipo = ?
					WHERE id_menu_acesso = ? ";

			$stmt = mysqli_prepare($conn, $sql);

			mysqli_stmt_bind_param($stmt, "ii", $status, $id);

			if (mysqli_stmt_execute($stmt)) 
			{
				echo "Alterado com sucesso!";
			} 
			else 
			{
				echo "Problema ao alterar status! " . mysqli_error($conn);
			}
		}
	}

?>