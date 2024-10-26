<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
	<div class="navbar-container d-flex content">
		<div class="bookmark-wrapper d-flex align-items-center">
			<ul class="nav navbar-nav d-xl-none">
				<li class="nav-item">
					<a class="nav-link menu-toggle" href="#"><i class="ficon" data-feather="menu"></i></a>
				</li>
			</ul>

			<div class="me-1 ms-1 h4"><?php echo $title; ?></div>
		</div>

		<ul class="nav navbar-nav align-items-center ms-auto">

			<li class="nav-item d-none d-lg-block">
				<a class="nav-link nav-link-style" id="estilo">
					<i class="ficon" data-feather="<?php echo $icon; ?>"></i>
				</a>
			</li>
            
            <?php
            
				$sql = "SELECT *
                        FROM notificacao_professor np
                        WHERE np.status = 1
                        AND np.id_professor = ? ";

				$stmt = mysqli_prepare($conn, $sql);

				mysqli_stmt_bind_param($stmt, "i", $_SESSION['id_professor']);

				mysqli_stmt_execute($stmt);

				$result = mysqli_stmt_get_result($stmt);
            
                $count = mysqli_num_rows($result);

                if ($count > 0) 
                {
                    $count_txt = ($count == 1) ? "$count Nova" : "$count Novas";
                    
                    echo '<li class="nav-item dropdown dropdown-notification me-25">
                            <a class="nav-link" href="#" data-bs-toggle="dropdown">
                                <i class="ficon" data-feather="bell"></i>
                                <span class="badge rounded-pill bg-danger badge-up">'.$count.'</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
                                <li class="dropdown-menu-header">
                                    <div class="dropdown-header d-flex">
                                        <h4 class="notification-title mb-0 me-auto">Notificações</h4>
                                        <div class="badge rounded-pill badge-light-primary">'.$count_txt.'</div>
                                    </div>
                                </li>';

                    while($row = mysqli_fetch_array($result))
                    {
                        if(!empty($row))
                        {
                            extract($row);

                            echo'<li class="scrollable-container media-list">
                                  <a class="d-flex" onclick="linkNotificacao('.$id_notificacao.', \''.$link.'\')" href="#">
                                   <div class="list-item d-flex align-items-start">
                                    <div class="me-1">
                                     <div class="avatar">
                                      <img src="'.$raiz.'app-assets/images/portrait/small/avatar-s-10.jpg" alt="avatar" width="32" height="32">
                                     </div>
                                    </div>
                                    <div class="list-item-body flex-grow-1">
                                     <p class="media-heading">
                                      <span class="fw-bolder">'.$titulo.'</span>
                                     </p>
                                     <small class="notification-text">'.$descricao.'</small>
                                    </div>
                                   </div>
                                  </a>
                                  </li>';
                        }
                    }
/*
                    echo' <li class="dropdown-menu-footer">
                           <a class="btn btn-primary w-100" href="#">Ler todas as notificações</a>
                          </li>';
*/
                    echo'</ul>
                         </li>';

                }

            ?>

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
								$avatar = $raiz.'app-assets/images/fotos/'.$_SESSION['foto'];
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
                    <?php //if( !empty($acessos['perfil']) && $acessos['perfil']['leitura'] == true ){ ?>
					<!--a class="dropdown-item" href="<?= $raiz ?>perfil.php">
						<i class="me-50" data-feather="user"></i> Perfil
					</a-->
                    <?php //} ?>
                    <?php if( !empty($acessos['configuracao']) && $acessos['configuracao']['leitura'] == true ){ ?>
					<a class="dropdown-item" href="<?= $raiz ?>configuracao.php">
						<i class="me-50" data-feather="settings"></i> Configurações
					</a>
                    <?php } ?>
					<!--a type="button" class="dropdown-item" href="<?= $raiz ?>videos.php">
						<i class="me-50" data-feather="youtube"></i> Tutoriais 
					</a-->
					<a class="dropdown-item" href="<?= $raiz ?>logout.php">
						<i class="me-50" data-feather="power"></i> Sair
					</a>
				</div>
			</li>
		</ul>
	</div>
</nav>