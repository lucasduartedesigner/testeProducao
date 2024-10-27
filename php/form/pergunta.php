<?php

    session_start(); 

	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);

    include_once("../../conn/conn.php");  

    include_once("../function/db.php");  

	include('../../class/database.php');

	$obj   = new Database();

	$table = 'pergunta';

	extract($_POST);

	//$gabarito = (!empty($gabarito)) ? $gabarito : 0;

    $gabarito = 1;
    $status   = (!empty($status)) ? $status : 1;

    if(!empty($ordem))
    {
        $new_ordem = $ordem;
    }
    else
    {
        $sql = "SELECT MAX(ordem) + 1 AS new_ordem
                FROM pergunta
                WHERE id_problema = ? 
                AND tipo = ? ";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "ii", $id_problema, $tipo);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row    = mysqli_fetch_array($result);

        $new_ordem = (!empty($row['new_ordem'])) ? $row['new_ordem'] : 1;
    }

	$arrayDados = array( 
						 "id_problema"   => "'$id_problema'",
						 "ordem"         => "'$new_ordem'",
						 "tipo"          => "'$tipo'",
						 "descricao"     => "'$descricao'",
						 "gabarito"      => "'$gabarito'",
						 "status"	     => "'$status'",
                         "top_position"  => "'$top_position'",
                         "left_position" => "'$left_position'"
						);

    if($tipo == 1 && !empty($id_tipo_anamnese))
    {
        $arrayDados["id_tipo_anamnese"] = $id_tipo_anamnese;
    }

    if($tipo == 3 && !empty($valor))
    {
        $arrayDados["valor"] = floatDB($valor);
    }

    $arrayDados = removeNullFromArray($arrayDados);

	//Se existir id monta where
	if(!empty($id_pergunta))
	{
		$where = " id_pergunta = $id_pergunta ";
		$obj->update($table, $arrayDados, $where);
	}
	else
	{        
		$obj->insert($table, $arrayDados);
		$id_pergunta = $obj->getResult()[0];
	}

	$table = 'resposta';

	$arrayDados = array( 
						 "id_pergunta" => "'$id_pergunta'",
						 "descricao"   => "'$resposta'",
						 "status"	   => "'$status'"
						);

    $arrayDados = removeNullFromArray($arrayDados);

	//Se existir id monta where
	if(!empty($id_resposta))
	{
		$where = " id_resposta = $id_resposta ";
		$obj->update($table, $arrayDados, $where);
	}
	else
	{        
		$obj->insert($table, $arrayDados);
		$id_resposta = $obj->getResult()[0];
	}

    if(!empty($_FILES['file']['name']) && !empty($id_resposta))
    {
        $uploaddir = '../../app-assets/images/arquivos/';

        if (!is_dir($uploaddir)) 
        {
            mkdir($uploaddir, 0777, true);
        }

        $name = $_FILES['file']['name'];

        $ext  = explode('.',$name);
        $ext  = $ext[1];

        $new  = "resposta-$id_resposta.$ext";

        $uploadfile = $uploaddir . basename($new);

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) 
        {  
            $sql = "UPDATE resposta 
                    SET arquivo = ?
                    WHERE id_resposta = ? ";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param($stmt, "si", $new, $id_resposta);

            mysqli_stmt_execute($stmt);

            mysqli_stmt_close($stmt);
        }

    }

    echo $id_problema;

/*
    $response = array(
        'id_pergunta' => $id_pergunta,
        'descricao'   => $descricao,
        'top_position'=> $top_position,
        'left_position'=> $left_position,
        'resposta'    => $resposta,
        'arquivo'     => $arquivo
    );

    echo json_encode($response);

*/
?>