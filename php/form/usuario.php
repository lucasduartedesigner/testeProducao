<?php

    session_start();

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require_once '../../assets/PHPMailer-master/src/Exception.php';
	require_once '../../assets/PHPMailer-master/src/PHPMailer.php';
	require_once '../../assets/PHPMailer-master/src/SMTP.php';

	include_once('../../class/email.php');

	include_once('../../class/pessoa.php');

	include_once('../function/usuario.php');

	$table = 'pessoa';

	$pessoaHandler = new PessoaHandler($table, $_POST);

	extract($_POST);

	$pessoaHandler->updateOrCreateUsuario($id_pessoa, $usuario, $nivel_acesso, $reset);

?>