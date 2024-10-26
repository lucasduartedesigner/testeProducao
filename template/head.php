<?php

	$id_config = 1;

	$sql = "SELECT name, site, description, logo, icone
            FROM config WHERE id_config = ? ";

	$stmt = mysqli_prepare($conn, $sql);

	mysqli_stmt_bind_param($stmt, "i", $id_config);
	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);
	$row    = mysqli_fetch_array($result);

	if(!empty($row))
	{
		extract($row);
	}

	//Define o nome do arquivo acessado
	$ArrPATH  = explode("/",$_SERVER['SCRIPT_NAME']);
	$path 	  = $ArrPATH[count($ArrPATH)-1];
	$namePage = str_replace(".php" , "", $path);

?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">

    <meta name="description" content="Aplicativo <?php echo $name ?> - <?php echo $description ?>">
    <meta name="author" content="Lucas Duarte">

    <title>App <?php echo $name ?> - <?php echo $title ?></title>

    <link rel="apple-touch-icon" href="<?php echo $icone ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $icone ?>">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <?php include_once("{$raiz}template/css.php"); ?>

	<?php if($return == 1){	?>
		<script>
			window.location.replace("<?= $raiz ?>index.php");
		</script>
	<?php } ?>

</head>
