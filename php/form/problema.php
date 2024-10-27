<?php

    session_start(); 

    include_once("../../conn/conn.php");  

    include_once("../function/db.php");  

	include('../../class/database.php');

	$obj   = new Database();

	$table = 'problema';

	extract($_POST);

	$arrayDados = array( 
						 "nome"	 	         => "'$nome'",
						 "disparador"        => "'$disparador'",
						 "identificacao"     => "'$identificacao'",
						 "desc_hda"          => "'$desc_hda'",
						 "desc_hpp"          => "'$desc_hpp'",
						 "desc_hs"           => "'$desc_hs'",
						 "desc_hpf"          => "'$desc_hpf'",
						 "diagnostico"       => "'$diagnostico'",
						 "cod_status"	     => "'$cod_status'"
						);

    $arrayDados = removeNullFromArray($arrayDados);

	//Se existir id monta where
	if(!empty($id_problema))
	{
		$where = " id_problema = $id_problema ";
		$obj->update($table, $arrayDados, $where);
	}
	else
	{        
		$obj->insert($table, $arrayDados);
		$id_problema = $obj->getResult()[0];
        
        if(!empty($id_problema))
        {
            $sql = "INSERT INTO exame_fisico (descricao, cod_status, id_problema, cod_tipo, ordem, user_created, top_position, left_position)
                    SELECT nome AS descricao, status, ? AS id_problema, 2 AS tipo, id_config_exame_fisico AS ordem, ? AS user_created, top_position, left_position
                    FROM config_exame_fisico
                    WHERE status IS NOT NULL
                    ORDER BY id_config_exame_fisico";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param($stmt, "ii", $id_problema, $_SESSION['id_professor']);

            mysqli_stmt_execute($stmt);

            mysqli_stmt_close($stmt);

        }

	}

    if(!empty($_FILES['file']['name']) && !empty($id_problema))
    {
        $uploaddir = '../../app-assets/images/arquivos/';

        if (!is_dir($uploaddir)) 
        {
            mkdir($uploaddir, 0777, true);
        }

        $name = $_FILES['file']['name'];

        $ext  = explode('.',$name);
        $ext  = $ext[1];

        $new  = "problema-$id_problema.$ext";

        $uploadfile = $uploaddir . basename($new);

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) 
        {
            $sql = "UPDATE problema 
                    SET arquivo = ?
                    WHERE id_problema = ? ";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param($stmt, "si", $new, $id_problema);

            mysqli_stmt_execute($stmt);

            mysqli_stmt_close($stmt);
        }
    }

    echo $id_problema;

?>