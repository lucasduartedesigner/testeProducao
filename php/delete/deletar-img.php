<?php

    session_start(); 

    include_once("../../conn/conn.php"); 

    if(!empty($_POST['id']) and !empty($_POST['name']))
	{
        $id     = $_POST['id'];
        $name   = $_POST['name'];
        $title  = $_POST['dir'];
        $return = false;

		$uploaddir = '../../app-assets/images/fotos/estudante/';

		$filePath = $uploaddir . $title;

		// Verificar se o arquivo existe
		if (file_exists($filePath))
		{
			// Remover o arquivo do servidor
			if (unlink($filePath)) 
			{
				// Remover o registro do banco de dados
				if (!empty($id)) 
				{
                    $return = true;
				}
			}
			else
			{
				echo "Falha ao remover o arquivo!";
			}
		}
		else 
		{
			$return = true;
		}

        if($return == true)
        {
            $sql = "UPDATE $name SET foto = null WHERE id_$name = ? ";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param($stmt, "i", $id);
           
            if (mysqli_stmt_execute($stmt))
            {
                echo "Deletado com sucesso!";
            }
            else 
            {
                echo "Problema ao deletar imagem! " . $sql . "<br>" . mysqli_error($conn); exit;
            }
        }
    }

?>