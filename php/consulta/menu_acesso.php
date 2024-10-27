<?php

    session_start(); 

    include_once("../../conn/conn.php");

    $id_nivel = $_POST['id'];

	$html = '';

	$sql = "SELECT nome, id_menu
			FROM menu
			GROUP BY nome
			ORDER BY ordem";

	$sql = mysqli_query($conn, $sql);

	while($row = mysqli_fetch_array($sql))
	{

		if(!empty($row))
		{
			extract($row);
		}

		$title = ucfirst(str_replace("_", " ", $nome));

		$html .=  "<tr>";
		$html .=  "<td class='text-nowrap fw-bolder w-40 pb-2 pt-2'>
					$title
				   </td>";

		$sql1 = "SELECT leitura, editar, deletar
				 FROM menu_acesso 
				 WHERE id_nivel_acesso = ? 
				 AND id_menu = ?
				 ORDER BY id_menu_acesso";

		$stmt = mysqli_prepare($conn, $sql1);

		mysqli_stmt_bind_param($stmt, "ii", $id_nivel, $id_menu);
		mysqli_stmt_execute($stmt);

		$result = mysqli_stmt_get_result($stmt);
		$row1   = mysqli_fetch_assoc($result);

		$leitura = (!empty($row1['leitura']) && $row1['leitura'] == 1) ? 'checked' : '';
		$editar  = (!empty($row1['editar']) && $row1['editar'] == 1) ? 'checked' : '';
		$deletar = (!empty($row1['deletar']) && $row1['deletar'] == 1) ? 'checked' : '';

		$checkboxes = [
						['id' => 'l', 'label' => 'Visualizar', 'value' => 'l', 'checked' => $leitura],
						['id' => 'e', 'label' => 'Editar', 'value' => 'e', 'checked' => $editar],
						['id' => 'd', 'label' => 'Deletar', 'value' => 'd', 'checked' => $deletar]
					  ];

		foreach ($checkboxes as $checkbox) 
		{
			$checkboxId 	 = $checkbox['id'];
			$checkboxLabel 	 = $checkbox['label'];
			$checkboxValue 	 = $id_menu . '-' . $checkbox['value'];
			$checkboxChecked = $checkbox['checked'];

			$html .= "<td class='w-20 pb-2 pt-2'>
						<div class='d-flex justify-content-between'>
							<div class='form-check form-check-primary'>
								<input class='form-check-input' type='checkbox' name='menu' id='$checkboxId-$id_menu' value='$checkboxValue' $checkboxChecked>
								<label class='form-check-label' for='$checkboxId-$id_menu'> $checkboxLabel </label>
							</div>
						</div>
					</td>";
		}

		$html .= "</tr>";

		unset($leitura, $editar, $deletar);

	}

	echo $html;

?>