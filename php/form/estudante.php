<?php

    session_start(); 

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

    include_once("../../conn/conn.php");  

    include_once("../function/db.php");  

	include('../../class/database.php');

	$obj   = new Database();

	$table = 'estudante';

	extract($_POST);

    $cpf   = somenteNumero($cpf);
    $senha = md5($cpf);

	$arrayDados = array( 
						 "nome"	 	 => "'$nome'",
						 "matricula" => "'$matricula'",
						 "cpf" 	 	 => "'$cpf'",
						 "email" 	 => "'$email'",
						 "codcurso"	 => "'$codcurso'",
						 "periodo" 	 => "'$periodo'",
						 "semestre"	 => "'$semestre'",
						 "codturma"	 => "'MED0$periodo'",
						 "subturma"	 => "'$subturma'",
						 "status"	 => "'$status'"
						);

    if((!empty($reset) && $reset == 1) || empty($id_estudante)) 
    {
        $arrayDados['senha'] = "'$senha'";
        $arrayDados['reset'] = 1;
    }

    $arrayDados = removeNullFromArray($arrayDados);

	//Se existir id monta where
	if(!empty($id_estudante))
	{
		$where = " id_estudante = $id_estudante ";
		$obj->update($table, $arrayDados, $where);
	}
	else
	{        
		$obj->insert($table, $arrayDados);
		$id_estudante = $obj->getResult()[0];
	}

?>