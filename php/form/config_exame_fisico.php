<?php

    session_start(); 

	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);

    include_once("../../conn/conn.php");  

    include_once("../function/db.php");  

	include('../../class/database.php');

	$obj   = new Database();

	$table = 'exame_fisico';

	extract($_POST);

    $status = (!empty($status)) ? $status : 1;

	$arrayDados = array( 
						 "nome"          => "'$nome'",
						 "status"	     => "'$status'",
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
		$id_pergunta = $obj->getResult()[0];
	}

?>