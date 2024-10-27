<?php

    $arrayProfessor = array();

	$sql = "SELECT * FROM professor
			WHERE status = 1
			ORDER BY nome";

	$result = $conn->query($sql);

	if ($result->num_rows > 0)
	{
        $arrayProfessor[0] = '';

		while($row1 = $result->fetch_assoc()) 
		{
            $id_professor = $row1['id_professor'];
            $professor    = $row1['nome'];

            $arrayProfessor[$id_professor] = $professor;
	  	}
	}

?>