<?php

	require_once("dispositivo.php");

	//Verifica se existe usuario no banco de dados
	function valida_login($conn, $usuario, $senha)
	{
		$sql = "SELECT id_estudante AS id_pessoa
                FROM estudante
                WHERE matricula = ?
                AND senha = ?

                UNION ALL 

                SELECT id_professor AS id_pessoa
                FROM professor
                WHERE matricula = ?
                AND senha = ? ";

        $stmt = mysqli_prepare($conn, $sql);

		mysqli_stmt_bind_param($stmt, "ssss", $usuario, $senha, $usuario, $senha);
		mysqli_stmt_execute($stmt);

		$rs  = mysqli_stmt_get_result($stmt);
		$row = mysqli_fetch_assoc($rs);

		return (!empty($row['id_pessoa'])) ? true : false;

	}

	//Busca os dados do usuario e salva em sessão
	function sessionDadosUsuario($conn, $usuario)
	{
        $dispositivo = (isMobileDevice()) ? "Mobile" : "Desktop";
        $ip_acesso 	 = get_client_ip();
        $sistema     = getOS();
        $navegador   = getBrowser();

		$sql = "SELECT p.*, n.nome nivel_acesso
			    FROM professor p
				 LEFT JOIN nivel_acesso n 
					ON p.id_nivel_acesso = n.id_nivel_acesso
			    WHERE matricula = ? 
			    LIMIT 1";

        $stmt = mysqli_prepare($conn, $sql);

		mysqli_stmt_bind_param($stmt, "s", $usuario);

		mysqli_stmt_execute($stmt);

		$rs  = mysqli_stmt_get_result($stmt);
		$row = mysqli_fetch_assoc($rs);

		if(!empty($row))
		{
            $id_professor = $row['id_professor'];

            $sql = "INSERT INTO log_acesso_professor (id_professor, navegador, sistema, dispositivo, ip_acesso)
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);
            
            mysqli_stmt_bind_param($stmt, "issss", $id_professor, $navegador, $sistema, $dispositivo, $ip_acesso);

            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            
            foreach ($row as $key => $value) 
			{
				$_SESSION[$key] = $value;
			}

            $url = ($_SERVER['HTTP_HOST'] == "localhost") ? "/testeProducao/php/form/login.php" : "/php/form/login.php";
            
			$pag = $_SERVER['REQUEST_URI'];

			if($url === $pag )
			{
				header("Location: ../../dashboard.php");
			}
			else
			{
				header("Refresh: 0");
			}
		}
		else
		{
            $sql = "SELECT e.*
                    FROM estudante e
                    WHERE matricula = ? 
                    LIMIT 1";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param($stmt, "s", $usuario);
            mysqli_stmt_execute($stmt);

            $rs  = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($rs);

            if(!empty($row))
            {
                $id_estudante = $row['id_estudante'];

                $sql = "INSERT INTO log_acesso_estudante (id_estudante, navegador, sistema, dispositivo, ip_acesso)
                        VALUES (?, ?, ?, ?, ?)";

                $stmt = mysqli_prepare($conn, $sql);

                mysqli_stmt_bind_param($stmt, "issss", $id_estudante, $navegador, $sistema, $dispositivo, $ip_acesso);

                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                foreach ($row as $key => $value) 
                {
                    $_SESSION[$key] = $value;
                }

                $url = ($_SERVER['HTTP_HOST'] == "localhost") ? "/testeProducao/php/form/login.php" : "/php/form/login.php";

                $pag = $_SERVER['REQUEST_URI'];

                if($url === $pag )
                {
                    header("Location: ../../estudante/perfil.php");
                }
                else
                {
                    header("Refresh: 0");
                }
            }
            else
            {
                $_SESSION['loginErro'] = "Usuário ou senha Inválido!";

                header("Location: ../../index.php");

                $return = 1;

            }
		}
	}
?>