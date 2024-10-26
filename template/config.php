<?php

	//Inicia sessão
    session_start();

	if(empty($raiz)) { $raiz = ""; }

	//Incluindo a conexão com banco de dados   
    include_once("{$raiz}conn/conn.php");

	//Inclui funções
    include_once("{$raiz}php/function/db.php");

	//Altera o timezone para pt-br
	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	setlocale(LC_TIME, 'pt_BR.utf8');
	date_default_timezone_set('America/Sao_Paulo');

	$return = 0;

	//Verifica se fez login
	if(empty($_SESSION['id_pessoa']))
	{
		if(empty($_COOKIE['login']))
		{
			$_SESSION['loginErro'] = "Você precisa fazer login para acessar o sistema!";

			header("Location: {$raiz}index.php");

			$return = 1;
		}
		else
		{
			$user = $_COOKIE['login'];

			//Inclui o arquivo com a function de validação de usuario
			require_once("{$raiz}php/function/valida.php");

			sessionDadosUsuario($conn, $user);
		}
	}
    else
    {
	   unset($_SESSION['msg']);
    }

	//Configura modo escuro
	if(@$_SESSION['estilo'] == 1)
	{
		$dark = "dark-layout";
		$fill = "#283046";
		$mark = "#343D55";
		$icon = "sun";
	}
	else
	{
		$dark = "";
		$fill = "#ffffff";		
		$mark = "#f3f2f7";		
		$icon = "moon";		
	}

	//Configura menu icone
    $menu =  " menu-collapsed";

	$id_setor = (!empty($_GET['setor'])) ? $_GET['setor'] : 5;

	$url = "";

?>