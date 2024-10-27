<?php

    session_start(); 

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

    include_once("../../conn/conn.php"); 

    include_once("../function/arquivos.php");  

	$id   = $_GET['id'];
	$file = $_FILES['file'];

	$uploaddir = '../../app-assets/images/exames/';

	if (!is_dir($uploaddir)) 
	{
		mkdir($uploaddir, 0777, true);
	}

	// Gere um nome único para o arquivo
	$ext = pathinfo($file['name'], PATHINFO_EXTENSION);

	$uniqueName = uniqid('exames-') . '.' . $ext;

	$uploadFile = $uploaddir . $uniqueName;

	echo "<pre>";

	// Verifique se o arquivo é válido
	if ($file['error'] === UPLOAD_ERR_OK) 
	{
		// Compacte a imagem antes do envio
		$compressedImage = compressImage($file['tmp_name'], $uploadFile);

		if ($compressedImage) 
		{
			echo "O arquivo é válido e foi carregado com sucesso.\n";

			if (!empty($id))
			{
				include('../../class/database.php');

				$obj   = new Database();

				$table = 'imagem_exames';

				$arrayDados = array( "nome" => "'$uniqueName'", "id_agenda" => "$id" );

				var_dump($arrayDados);

				$obj->insert($table, $arrayDados);

				$id_imagem_exames = $obj->getResult()[0];

				if (!empty($id_imagem_exames)) 
				{
					echo "Adicionado com sucesso!\n";
				}
			}
		} 
		else 
		{
			echo "Falha ao compactar a imagem!\n";
		}
	} 
	else 
	{
		echo "Algo está errado com o arquivo!\n";
	}

	echo "</pre>";

?>