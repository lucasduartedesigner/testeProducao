<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
	<div class="navbar-header">
		<ul class="nav navbar-nav flex-row">
			<li class="nav-item me-auto">
				<a class="navbar-brand" href="<?= $raiz ?>dashboard.php">
					<img src="<?= $logo ?>" style="margin-left: -0.5em;margin-top: -10px;width: 150px" alt="logo"/>
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
		<ul class="navigation navigation-main mb-5" id="main-menu-navigation" data-menu="menu-navigation">
			<?php

				$sql = "SELECT m.id_menu, m.nome, m.link, m.icone, ma.leitura, ma.editar, ma.deletar
						FROM menu m
                        INNER JOIN menu_acesso ma ON m.id_menu = ma.id_menu
                        WHERE ma.id_nivel_acesso = ?
                        AND ma.leitura = 1
                        GROUP BY m.id_menu, m.nome, m.link, m.icone
						ORDER BY m.ordem";

				$stmt = mysqli_prepare($conn, $sql);

                mysqli_stmt_bind_param($stmt, "i", $_SESSION['id_nivel_acesso']);

                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);

                $acessos = array();

                while ($row = mysqli_fetch_assoc($result)) 
                {
					if(!empty($row))
					{
                        extract($row);

                        $pagina = str_replace(".php", "", $link);

                        $class = ($namePage == $pagina) ? 'active' : '';

				        echo itemMenu($id_menu, $nome, $raiz.$link, $icone, $class, ""); 

                        $acessos[$pagina] = [
                                                "leitura" => $leitura,
                                                "editar"  => $editar,
                                                "deletar" => $deletar
                                            ];
					}
				}

                $_SESSION['acessos'] = $acessos;

			?>
		</ul>
	</div>
</div>