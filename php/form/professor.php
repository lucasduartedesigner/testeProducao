<?php

    session_start(); 

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

    include_once("../../conn/conn.php");  

    include_once("../function/db.php");  

	include('../../class/database.php');

	$obj   = new Database();

	$table = 'professor';

	extract($_POST);

    $cpf   = somenteNumero($cpf);
    $senha = md5($cpf);

	$arrayDados = array( 
						 "nome"	 	       => "'$nome'",
						 "matricula"       => "'$matricula'",
						 "cpf" 	 	       => "'$cpf'",
						 "email" 	       => "'$email'",
						 "id_nivel_acesso" => "'$id_nivel_acesso'",
						 "status"	       => "'$status'"
						);

    if((!empty($reset) && $reset == 1) || empty($id_professor)) 
    {
        $arrayDados['senha'] = "'$senha'";
        $arrayDados['reset'] = 1;
    }

    $arrayDados = removeNullFromArray($arrayDados);

	//Se existir id monta where
	if(!empty($id_professor))
	{
		$where = " id_professor = $id_professor ";
		$obj->update($table, $arrayDados, $where);
	}
	else
	{        
		$obj->insert($table, $arrayDados);
		$id_professor = $obj->getResult()[0];
	}

?>