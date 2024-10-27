<?php

    $arrayProfessor = array();

	$sql = "SELECT * FROM pessoa
			WHERE cod_status = 1
			AND cod_tipo = 1
			ORDER BY nome";

	$result = $conn->query($sql);

	if ($result->num_rows > 0)
	{
        $arrayProfessor[0] = '';

		while($row1 = $result->fetch_assoc()) 
		{
            $id_pessoa = $row1['id_pessoa'];
            $professor    = $row1['nome'];

            $arrayProfessor[$id_pessoa] = $professor;
	  	}
	}

?>