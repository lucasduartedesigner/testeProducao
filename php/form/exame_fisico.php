<?php

    session_start(); 

    include_once("../../conn/conn.php");  

    include_once("../function/db.php");  

	include('../../class/database.php');

	$obj   = new Database();

	$table = 'exame_fisico';

	extract($_POST);

    $cod_status   = (!empty($cod_status)) ? $cod_status : 1;

    if(!empty($ordem))
    {
        $new_ordem = $ordem;
    }
    else
    {
        $sql = "SELECT MAX(ordem) + 1 AS new_ordem
                FROM exame_fisico
                WHERE id_problema = ? 
                AND tipo = ? ";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "ii", $id_problema, $cod_tipo);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row    = mysqli_fetch_array($result);

        $new_ordem = (!empty($row['new_ordem'])) ? $row['new_ordem'] : 1;
    }

	$arrayDados = array( 
						 "id_problema"   => "'$id_problema'",
						 "ordem"         => "'$new_ordem'",
						 "cod_tipo"      => "'$cod_tipo'",
						 "descricao"     => "'$descricao'",
						 "resposta"      => "'$resposta'",
						 "cod_status"	 => "'$cod_status'",
                         "top_position"  => "'$top_position'",
                         "left_position" => "'$left_position'"
						);

    $arrayDados = removeNullFromArray($arrayDados);

	//Se existir id monta where
	if(!empty($id_exame_fisico))
	{
		$where = " id_exame_fisico = $id_exame_fisico ";
		$obj->update($table, $arrayDados, $where);
	}
	else
	{        
		$obj->insert($table, $arrayDados);
		$id_exame_fisico = $obj->getResult()[0];
	}

    if(!empty($_FILES['file']['name']) && !empty($id_exame_fisico))
    {
        $uploaddir = '../../app-assets/images/arquivos/';

        if (!is_dir($uploaddir)) 
        {
            mkdir($uploaddir, 0777, true);
        }

        $name = $_FILES['file']['name'];

        $ext  = explode('.',$name);
        $ext  = $ext[1];

        $new  = "resposta-$id_exame_fisico.$ext";

        $uploadfile = $uploaddir . basename($new);

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) 
        {  
            $sql = "UPDATE exame_fisico 
                    SET arquivo = ?
                    WHERE id_exame_fisico = ? ";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param($stmt, "si", $new, $id_exame_fisico);

            mysqli_stmt_execute($stmt);

            mysqli_stmt_close($stmt);
        }

    }

    echo $id_problema;

?>