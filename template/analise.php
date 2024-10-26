<?php

	//Verifica quantidade de situações problema totais
	$sql 	= "SELECT count(*) AS total 
			   FROM problema 
			   WHERE status IS NOT NULL ";

	$result = $conn->query($sql);
	$row 	= $result->fetch_array();

	$total_problema = $row["total"];

	//Verifica quantidade de estudantes total
	$sql 	= "SELECT count(*) AS total 
			   FROM estudante 
			   WHERE status IS NOT NULL ";

	$result = $conn->query($sql);
	$row 	= $result->fetch_array();

	$total_estudante = $row["total"];

	//Verifica quantidade de exames total
	$sql 	= "SELECT count(*) AS total 
			   FROM avaliacao 
			   WHERE status IS NOT NULL ";

	$result = $conn->query($sql);
	$row 	= $result->fetch_array();

	$total_avaliacao = $row["total"];

	$sql 	= "SELECT count(*) AS total 
			   FROM pergunta p 
               INNER JOIN pergunta_turma pt 
               ON p.id_pergunta = pt.id_pergunta 
               AND pt.status IS NOT NULL
			   WHERE p.status IS NOT NULL
               AND p.gabarito = 1 ";

	$result = $conn->query($sql);
	$row 	= $result->fetch_array();

	$total_acertos = $row["total"];

	$sql 	= "SELECT count(*) AS total 
			   FROM pergunta_turma pt
			   WHERE pt.status IS NOT NULL";

	$result = $conn->query($sql);
	$row 	= $result->fetch_array();

	$total_marcacao = $row["total"];

    $diferenca = $total_marcacao - $total_acertos;

    $porcentagem = (!empty($total_acertos) && !empty($total_marcacao)) ? (($total_acertos / $total_marcacao) * 100) : 100;

?>