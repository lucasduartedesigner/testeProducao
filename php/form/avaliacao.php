<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

    session_start(); 

    include_once("../../conn/conn.php");  

    include_once("../function/db.php");  

	include('../../class/database.php');

	$obj   = new Database();

	$table = 'avaliacao';

	extract($_POST);

	$data_inicio = databind($data_inicio);
	$data_fim    = databind($data_fim);

	$arrayDados = array( 
						 "id_problema"	 	 => "'$id_problema'",
						 "data_inicio"       => "'$data_inicio'",
						 "data_fim"          => "'$data_fim'",
						 "codcurso"	         => "'$codcurso'",
						 "periodo" 	         => "'$periodo'",
						 "semestre"	         => "'$semestre'",
						 "codturma"	         => "'MED0$periodo'",
						 "status"	         => "'$status'",
						 "id_professor"      => "'$id_professor'"
						);

    $arrayDados = removeNullFromArray($arrayDados);

	//Se existir id monta where
	if(!empty($id_avaliacao))
	{
		$where = " id_avaliacao = $id_avaliacao ";
		$obj->update($table, $arrayDados, $where);
	}
	else
	{        
		$obj->insert($table, $arrayDados);
		$id_avaliacao = $obj->getResult()[0];
	}

    echo $id_avaliacao;

    if(!empty($id_avaliacao) && !empty($subturma))
    {
        $sql_delete = "DELETE FROM avaliacao_subturma WHERE id_avaliacao = ?";
        $stmt_delete = mysqli_prepare($conn, $sql_delete);

        mysqli_stmt_bind_param($stmt_delete, "i", $id_avaliacao);
        mysqli_stmt_execute($stmt_delete);
        mysqli_stmt_close($stmt_delete);

        $sql_subturma  = "INSERT INTO avaliacao_subturma (id_avaliacao, subturma) VALUES (?, ?)";
        $stmt_subturma = mysqli_prepare($conn, $sql_subturma);

        foreach ($subturma as $subturma) 
        {
            mysqli_stmt_bind_param($stmt_subturma, "is", $id_avaliacao, $subturma);
            mysqli_stmt_execute($stmt_subturma);
        }

        mysqli_stmt_close($stmt);

        mysqli_stmt_close($stmt_subturma);
    }

?>