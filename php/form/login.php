<?php

    session_start();

	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);

	//Inclui arquivo de conexão com banco
    require_once("../../conn/conn.php");  

	//Inclui o arquivo com a classe de login
	require_once("../../class/valida.php");

	//Inclui o arquivo com a function de validação
	require_once("../function/valida.php");

    //Inclui o arquivo com a function de validação
	require_once("../function/dispositivo.php");

	$usuario = !empty($_POST['usuario']) ? $_POST['usuario'] : '';
	$senha   = !empty($_POST['senha']) ? $_POST['senha'] : '';
	$senha 	 = md5($senha);
	$lembrar = (isset($_POST['lembrar'])) ? $_POST['lembrar'] : '';

	//Verifica se existe cookie criado
	if(isset($_COOKIE['login']))
	{
		$flag 	 = true;
		$usuario = $_COOKIE['login'];
	}
	else
	{
		//Valida os dados no banco de dados
		if (valida_login($conn, $usuario, $senha))
		{
			$flag = true;
		}
		else
		{
			$flag = false;
		}
	}

	if ($flag == true)
	{
		//Cria cookie caso coloque para manter conectado
		if(!empty($lembrar))
		{
			$cookie = Login::remember($usuario);	
		}
		else
		{
			$cookie = Login::forget($usuario);
		}

		sessionDadosUsuario($conn, $usuario);
	}
	else
	{
		$_SESSION['loginErro'] = "Usuário ou senha inválidos!";

        $url = ($_SERVER['HTTP_HOST'] == "localhost") ? "http://localhost/testeProducao/" : "http://localhost/testeProducao/";

		header('Location: '. $url);

		die('Não ignore meu cabeçalho...');

		exit();
	}

?>