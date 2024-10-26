<?php

    $arrayProblema = array();

	$sql = "SELECT * FROM problema
			WHERE cod_status = 1
			ORDER BY nome";

	$result = $conn->query($sql);

	if ($result->num_rows > 0)
	{
		while($row1 = $result->fetch_assoc()) 
		{
            $id_problema = $row1['id_problema'];
            $problema    = $row1['nome'];

            $arrayProblema[$id_problema] = $problema;
	  	}
	}

?>