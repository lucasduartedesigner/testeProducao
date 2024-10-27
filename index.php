<?php

	//Inicia sessão
    session_start();

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	if(empty($raiz)) { $raiz = ""; }

	//Incluindo a conexão com banco de dados   
    include_once("{$raiz}conn/conn.php");

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

?>
<!DOCTYPE html>
<html class="loading" lang="pt-br">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">

    <meta name="description" content="Aplicativo <?= $name ?> - <?= $description ?>">
    <meta name="author" content="Lucas Duarte">

    <title>App <?= $name ?> - <?= $description ?></title>
    <link rel="apple-touch-icon" href="<?= $icone ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= $icone ?>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">

    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/semi-dark-layout.css">

    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/pages/authentication.css">

    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
 
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-cover">
                    <div class="auth-inner row m-0">
                        <a class="brand-logo" href="index.php">
                            <img src="<?= $logo ?>" style="max-width: 280px" class="w-100" alt="logo"/>
                        </a>

                        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
								<img class="img-fluid" src="app-assets/images/pages/login-v2.svg" alt="imagem fundo" />
							</div>
                        </div>

                        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                                <h3 class="card-title fw-bold mb-1">Bem-vindo ao <?= $name ?>! 👋</h3>
                                <p class="card-text mb-2">Sua plataforma de <?= $description ?></p>
                                <form class="mt-2" action="php/form/login.php" method="POST">
                                    <div class="mb-2">
                                        <label class="form-label" for="usuario">Usuário</label>
                                        <input class="form-control" id="usuario" type="text" name="usuario" autofocus="" tabindex="1" required />
                                    </div>
                                    <div class="mb-2">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="login-password">Senha</label>
											<a href="esqueci_senha.php">
												<small>Esqueceu sua senha?</small>
											</a>
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input class="form-control form-control-merge" id="senha" type="password" name="senha" placeholder="············" tabindex="2" required />
											<span class="input-group-text cursor-pointer">
												<i data-feather="eye"></i>
											</span>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" id="remember-me" name="lembrar" type="checkbox" tabindex="3" />
                                            <label class="form-check-label" for="remember-me"> Manter conectado</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100" tabindex="4">Entrar</button>
                                </form>

								<?php if(isset($_SESSION['loginErro'])){ ?>
									<div class="alert alert-danger mt-2" role="alert">
										<div class="alert-body d-flex align-items-center">
											<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info me-50"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
											<span><?php echo $_SESSION['loginErro']; ?></span>
										</div>
									</div>
 								<?php unset($_SESSION['loginErro']); } ?>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="app-assets/vendors/js/vendors.min.js"></script>

    <script src="app-assets/js/core/app-menu.js"></script>
    <script src="app-assets/js/core/app.js"></script>

    <script>
        $(window).on('load', function() {

			setTimeout(function() { 
				$('.alert').hide();
   			 }, 3000);

        })
    </script>
</body>
</html>