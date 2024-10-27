<?php

    if(!empty($_POST['id_professor']) || !empty($_POST['id_estudante'])) 
    {
        session_start(); 

        include_once("../../conn/conn.php");  

        include_once("../function/db.php");  

        //Inclui classe com funções de interaçã ocom banco
        include('../../class/database.php');

        //Incia um objeto que acessa a Classe Database
        $obj = new Database();

        if(!empty($_POST['id_professor'])) 
        {
            $where = " id_professor = " . $_POST['id_professor'];

            $table = 'token';

            $arrayDados  = array(
                                 "status" => "0",
                                );

            if(!empty($token))
            {
                $obj->update($table, $arrayDados, $where);
            }

        }
        else
        {
            $where = " id_estudante = " . $_POST['id_estudante'];
        }

        //Tabela que vai fazer fazer CRUD
        $table = $_POST['tipo'];
        $senha = md5($_POST['senha']);
        $reset = 0;

        $arrayDados  = array(
                             "reset" => "'$reset'",
                             "senha" => "'$senha'"
                            );

        $obj->update($table, $arrayDados, $where);

        $_SESSION['reset'] = $reset;

        var_dump($obj->getResult());
    }

?>