<?php

    session_start();

   	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);

    include_once("../../conn/conn.php");  

    if(!empty($_POST['id']) and !empty($_POST['name']))
	{
        $id   = $_POST['id'];
        $name = $_POST['name'];

        $sql = "UPDATE $name SET cod_status = null WHERE id_$name = $id ";

		if (mysqli_query($conn, $sql))
		{
			echo "Deletado com sucesso!";
		}
		else 
		{
			echo "Problema ao deletar pessoa! " . $sql . "<br>" . mysqli_error($conn); exit;
		}
    }

?>