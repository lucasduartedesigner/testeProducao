<?php

    session_start(); 

    include_once("../../conn/conn.php");  

    include_once("../function/db.php");  

	include('../../class/database.php');

	$obj 	= new Database();

	$table 	= 'nivel_acesso';

	$status = 1;

	extract($_POST);

	$arrayDados = array( 
						 "nome"   => "'$nome'",
						 "status" => "'$status'"
						);

	if(!empty($id_nivel_acesso))
	{
		$where = " id_nivel_acesso = $id_nivel_acesso ";
		$obj->update($table, $arrayDados, $where);
	}
	else
	{
		$obj->insert($table, $arrayDados);
		$id_nivel_acesso = $obj->getResult()[0];
	}

    echo $id_nivel_acesso;

?>