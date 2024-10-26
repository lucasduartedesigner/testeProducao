<?php

	$sql = "SELECT * FROM nivel_acesso
			WHERE status = 1
			ORDER BY nome";

	$result = $conn->query($sql);

	if ($result->num_rows > 0)
	{

	  $disabled = "";

	  echo "<select class='form-control form-select' id='id_nivel_acesso' name='id_nivel_acesso' $disabled required>";

		while($row1 = $result->fetch_assoc()) 
		{
			$id_nivel_acesso = $row1["id_nivel_acesso"];
			$nome 			 = $row1["nome"];

			$selected = ($nivel_acesso == $id_nivel_acesso) ? "selected" : "";

		  	echo "<option value='$id_nivel_acesso' $selected>";
		  		echo $nome;
		  	echo "</option>";
	  	}

	  echo "</select>";

	  if($disabled !== "")
	  {
		  echo "<input type='hidden' name='nivel_acesso' value='$nivel_acesso'/>";
	  }

	}

?>