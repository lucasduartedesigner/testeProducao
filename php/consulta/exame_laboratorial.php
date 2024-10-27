<?php

    session_start(); 

    include_once("../../conn/conn.php");  

	if(isset($_POST['id']))
	{

		$id    = $_POST['id'];

		$mysql = new mysqli($servername, $username, $password, $dbname);

		$mysql->set_charset('utf8mb4');

		// Preparar a consulta SQL com um parâmetro
		$sql = 'SELECT e.*
                FROM exame_laboratorial e
                WHERE e.cod_status IS NOT NULL
                AND e.id_exame_laboratorial  = ? ';

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
            
            $data['dir'] = (!empty($data['arquivo'])) ? 'app-assets/images/arquivos/'. $data['arquivo'] : '';

			// Retornar os dados como resposta JSON
			echo json_encode($data);
		} 

		// Fechar a declaração e liberar os recursos
		$stmt->close();

	}
?>