<?php

    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include_once("../../conn/conn.php");  

    include_once("../function/db.php");  

	include('../../class/database.php');

	$obj   = new Database();

	$table = 'pergunta_turma';

    if(!empty($_SESSION))
    {
        extract($_SESSION);

        $id_pergunta_turma = $_POST['id_pergunta_turma'];
        $id_problema       = $_POST['id_problema'];
        $id_avaliacao      = $_POST['id_avaliacao'];
        $id_pergunta       = $_POST['id_pergunta'];
        $resposta          = $_POST['resposta'];
        $tipo              = $_POST['tipo'];
        $valor             = $_POST['valor'];

        $arrayDados = array( 
                             "id_pergunta"  => "'$id_pergunta'",
                             "resposta"     => "'$resposta'",
                             "valor"        => "'$valor'",
                             "user_updated" => "'$user_updated'"
                            );

        $arrayDados = removeNullFromArray($arrayDados);

        if(!empty($id_pergunta_turma))
        {
            $where = " id_pergunta_turma = $id_pergunta_turma ";
            $obj->update($table, $arrayDados, $where);
        }

    }
    else
    {
        echo "Precisa estar logado para fazer essa modificação.";
    }           

?>