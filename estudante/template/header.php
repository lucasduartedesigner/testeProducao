<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
	<div class="navbar-container d-flex content">
		<div class="bookmark-wrapper d-flex align-items-center">
			<ul class="nav navbar-nav d-xl-none">
				<li class="nav-item">
					<a class="nav-link menu-toggle" href="#"><i class="ficon" data-feather="menu"></i></a>
				</li>
			</ul>

			<div class="me-1 ms-1 h4"> <?php echo $title; ?></div>
		</div>

		<ul class="nav navbar-nav align-items-center ms-auto">

			<li class="nav-item d-none d-lg-block">
				<a class="nav-link nav-link-style" id="estilo">
					<i class="ficon" data-feather="moon"></i>
				</a>
			</li>

			<!--li class="nav-item dropdown dropdown-notification me-25">
				<a class="nav-link" href="#" data-bs-toggle="dropdown">
					<i class="ficon" data-feather="bell"></i>
					<span class="badge rounded-pill bg-danger badge-up">1</span>
				</a>
				<ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
					<li class="dropdown-menu-header">
						<div class="dropdown-header d-flex">
							<h4 class="notification-title mb-0 me-auto">Notificações</h4>
							<div class="badge rounded-pill badge-light-primary">1 Nova</div>
						</div>
					</li>
					<li class="scrollable-container media-list">
						<a class="d-flex" href="#">
							<div class="list-item d-flex align-items-start">
								<div class="me-1">
									<div class="avatar">
										<img src="<?= $raiz ?>app-assets/images/portrait/small/avatar-s-15.jpg" alt="avatar" width="32" height="32">
									</div>
								</div>
								<div class="list-item-body flex-grow-1">
									<p class="media-heading">
										<span class="fw-bolder">Exame já liberado!</span>
									</p>
									<small class="notification-text"> Envie notificação para seu cliente!</small>
								</div>
							</div>
						</a>
					</li>
					<li class="dropdown-menu-footer">
						<a class="btn btn-primary w-100" href="#">Ler todas as notificações</a>
					</li>
				</ul>
			</li-->
			<li class="nav-item dropdown dropdown-user">
				<a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<div class="user-nav d-sm-flex d-none">
						<span class="user-name fw-bolder"><?php echo @$_SESSION['nome']; ?></span>
						<span class="user-status"><?php echo @$_SESSION['nivel_acesso']; ?></span>
					</div>
					<span class="avatar">
						<?php

							if(!empty($_SESSION['foto']))
							{
								$avatar = $raiz.'app-assets/images/fotos/estudante/'.$_SESSION['foto'];
							}
							else
							{
								$avatar = $raiz.'app-assets/images/portrait/small/avatar-s-11.jpg';	
							}

							echo "<img class='round' src='$avatar' alt='avatar' height='40' width='40'>";
						?>
						<span class="avatar-status-online">
					</span>
				</a>
				<div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
					<a class="dropdown-item" href="<?= $raiz ?>estudante/perfil.php">
						<i class="me-50" data-feather="user"></i> Perfil
					</a>
					<a class="dropdown-item" href="<?= $raiz ?>logout.php">
						<i class="me-50" data-feather="power"></i> Sair
					</a>
				</div>
			</li>
		</ul>
	</div>
</nav>