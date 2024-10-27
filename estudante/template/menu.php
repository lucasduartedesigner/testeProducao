<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
	<div class="navbar-header">
		<ul class="nav navbar-nav flex-row">
			<li class="nav-item me-auto">
				<a class="navbar-brand" href="<?= $raiz ?>cliente/perfil.php">
					<img src="<?= $raiz ?><?= $logo ?>" style="margin-left: -0.5em;margin-top: -10px;width: 150px" alt="logo"/>
				</a>
			</li>
			<!--li class="nav-item nav-toggle">
				<a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse" id="menu">
					<i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
					<i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i>
				</a>
			</li-->
		</ul>
	</div>
	<div class="shadow-bottom"></div>
	<div class="main-menu-content mt-2">
		<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
			<?php

				$url = $_GET['url'] ?? 0;

				foreach($itens as $key => $value)
				{
					$active = ($url == $key) ? "active" : "";

					echo itemMenu($key, $value, "$path?url=$key", "<i data-feather='$icos[$key]'></i>", $active, ""); 
				}

			?>
		</ul>
	</div>
</div>