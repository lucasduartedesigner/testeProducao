<?php

    session_start(); 

    include_once("../../conn/conn.php"); 

    include_once("../function/db.php");  

	if(isset($_POST['id']))
	{

		$id  = $_POST['id'];

		$mysql = new mysqli($servername, $username, $password, $dbname);

		$mysql->set_charset('utf8mb4');

		// Preparar a consulta SQL com um parâmetro
		$sql = 'SELECT a.*, p.nome, 
                       GROUP_CONCAT(ast.subturma ORDER BY ast.subturma SEPARATOR ",") AS subturmas
                FROM avaliacao a
                INNER JOIN problema p
                    ON a.id_problema = p.id_problema AND p.cod_status IS NOT NULL
                LEFT JOIN avaliacao_subturma ast
                    ON a.id_avaliacao = ast.id_avaliacao
                WHERE a.status IS NOT NULL
                AND a.id_avaliacao = ? 
                GROUP BY a.id_avaliacao';

		// Preparar a declaração SQL
		$stmt = $mysql->prepare($sql);

		// Vincular o parâmetro à declaração
		$stmt->bind_param("i", $id);

		// Executar a consulta
		$stmt->execute();

		// Obter os resultados da consulta
		$result = $stmt->get_result();

		// Verificar se foram encontrados resultados
		if ($result->num_rows > 0)
		{
			// Obter os dados como um array associativo
			$data = $result->fetch_array(MYSQLI_ASSOC);

            $data['data_inicio'] = dataBR($data['data_inicio']);
            $data['data_fim']    = dataBR($data['data_fim']);

			// Retornar os dados como resposta JSON
			echo json_encode($data);
		} 

		// Fechar a declaração e liberar os recursos
		$stmt->close();

	}
?>