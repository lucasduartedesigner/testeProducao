<?php

	session_start();

	require_once("class/valida.php");

	$cookie = Login::forget($_SESSION['id_pessoa']);

   	session_destroy();

   	header("location: index.php");

   	exit();
?>
