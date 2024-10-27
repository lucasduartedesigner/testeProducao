<?php

    session_start(); 

    include_once("../../conn/conn.php");  

    include_once("../function/db.php");  

	include('../../class/database.php');

	$obj   = new Database();

	$table = 'exame_laboratorial';

	extract($_POST);

    $cod_status   = (!empty($cod_status)) ? $cod_status : 1;

	$arrayDados = array( 
						 "id_problema"   => "'$id_problema'",
						 "cod_tipo"      => "'$cod_tipo'",
						 "descricao"     => "'$descricao'",
						 "resposta"      => "'$resposta'",
						 "cod_status"	 => "'$cod_status'",
                         "valor"         => "'$valor'"
						);

    $arrayDados = removeNullFromArray($arrayDados);

	//Se existir id monta where
	if(!empty($id_exame_laboratorial))
	{
		$where = " id_exame_laboratorial = $id_exame_laboratorial ";
		$obj->update($table, $arrayDados, $where);
	}
	else
	{        
		$obj->insert($table, $arrayDados);
		$id_exame_laboratorial = $obj->getResult()[0];
	}

    if(!empty($_FILES['file']['name']) && !empty($id_exame_laboratorial))
    {
        $uploaddir = '../../app-assets/images/arquivos/';

        if (!is_dir($uploaddir)) 
        {
            mkdir($uploaddir, 0777, true);
        }

        $name = $_FILES['file']['name'];

        $ext  = explode('.',$name);
        $ext  = $ext[1];

        $new  = "laboratorial-$id_exame_laboratorial.$ext";

        $uploadfile = $uploaddir . basename($new);

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) 
        {  
            $sql = "UPDATE exame_laboratorial 
                    SET arquivo = ?
                    WHERE id_exame_laboratorial = ? ";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param($stmt, "si", $new, $id_exame_laboratorial);

            mysqli_stmt_execute($stmt);

            mysqli_stmt_close($stmt);
        }

    }

    echo $id_problema;

?>