<?php include('template/config.php'); ?>
<!DOCTYPE html>
<html class="loading" lang="pt-br">
<?php

	$title = "Painel de Controle";

	include('template/head.php');
	
	echo "<body class='vertical-layout vertical-menu-modern navbar-floating footer-static $menu $dark' data-menu='vertical-menu-modern'>";

	include('template/header.php');

	include('template/menu.php');

	include('template/analise.php');

?>

    <div class="app-content content">
        <div class="content-wrapper container-xxl p-0">
            <div class="content-body">
 
                <section id="dashboard-ecommerce">
                    <div class="row match-height">

                        <div class="col-xxl-8 col-xl-8 col-lg-12 col-12">
                            <div class="card card-statistics">
                                <div class="card-header">
                                    <h4 class="card-title">Estatísticas</h4>
                                    <div class="d-flex align-items-center">
                                        <p class="card-text font-small-2 me-25 mb-0">
											Mês de <?php echo mesExtenso(); ?>
										</p>
                                    </div>
                                </div>
                                <div class="card-body statistics-body" style="padding: 1.5rem 1.5rem !important;">
                                    <div class="row">
										<?php

                                            colunaEstatistica('Caso Clínico', $total_problema, 'trending-up', 'bg-light-primary');
                            
                                            colunaEstatistica('Estudantes', $total_estudante, 'user', 'bg-light-info');
                            
                                            colunaEstatistica('Avaliaçoes', $total_avaliacao, 'calendar', 'bg-light-warning');
                                    
                                            colunaEstatistica('Acertos', $total_acertos, 'check', 'bg-light-success');

										?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-xl-4 col-lg-12 col-12">
                            <div class="row match-height h-100">

								<?php //if( @$acessos['exames']['leitura'] == true ) { ?>
									<div class="col-lg-6 col-xl-6 col-6">
										<div class="card">
											<div class="card-body pb-50">
												<h6>Total Avaliações</h6>
												<h2 class="fw-bolder mb-1"><?php echo $total_avaliacao; ?></h2>
												<div id="statistics-order-chart"></div>
											</div>
										</div>
									</div>
  								<?php //} ?>

								<?php //if( @$acessos['transacoes']['leitura'] == true ) { ?>
									<div class="col-lg-6 col-xl-6 col-6">
										<div class="card card-tiny-line-stats">
											<div class="card-body pb-50">
												<h6>Acertos</h6>
												<h2 class="fw-bolder mb-1"><?php echo $total_acertos; ?></h2>
												<div id="statistics-profit-chart"></div>
											</div>
										</div>
									</div>
 								<?php //} ?>

                            </div>
                        </div>

            <?php

            function generateBrowserStatsHTML($conn, $raiz) {
                // Consulta SQL
                $sql = "SELECT navegador, COUNT(*) as qtd_visualizacoes
                        FROM log_acesso
                        GROUP BY navegador";

                $result = $conn->query($sql);

                // Total de visualizações para calcular porcentagens
                $total_views = 0;
                $browsers = [];

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $total_views += $row["total_visualizacoes"];
                        $browsers[] = $row;
                    }
                }

                // Gera o HTML
                $output = '
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card card-browser-states">
                        <div class="card-header">
                            <div>
                                <h4 class="card-title">Navegadores</h4>
                                <p class="card-text font-small-2">Contagem em tempo Real</p>
                            </div>
                            <div class="dropdown chart-dropdown">
                                <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Última Semana</a>
                                    <a class="dropdown-item" href="#">Último Mês</a>
                                    <a class="dropdown-item" href="#">Último Ano</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">';

                $browser_icons = [
                    "Chrome" => "google-chrome.png",
                    "Firefox" => "mozila-firefox.png",
                    "Safari" => "apple-safari.png",
                    "Internet Explorer" => "internet-explorer.png",
                    "Opera Mini" => "opera.png",
                    "Handheld Browser" => "apple-safari.png"
                ];

                foreach ($browsers as $browser) {
                    $browser_name = $browser["navegador"];
                    $views = $browser["total_visualizacoes"];
                    $percentage = ($total_views > 0) ? round(($views / $total_views) * 100, 1) : 0;

                    $icon = isset($browser_icons[$browser_name]) ? $browser_icons[$browser_name] : "default.png";
                    $chart_id = "browser-state-chart-" . strtolower(str_replace(" ", "-", $browser_name));

                    $output .= '
                    <div class="browser-states mt-4">
                        <div class="d-flex">
                            <img src="' . $raiz . 'app-assets/images/icons/' . $icon . '" class="rounded me-1" height="30" alt="' . $browser_name . '" />
                            <h6 class="align-self-center mb-0">' . $browser_name . '</h6>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="fw-bold text-body-heading me-1">' . $percentage . '%</div>
                            <div id="' . $chart_id . '"></div>
                        </div>
                    </div>';
                }

                $output .= '
                        </div>
                    </div>
                </div>';

                return $output;
            }

            echo generateBrowserStatsHTML($conn, $raiz);

            ?>

                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title">Assertividade das Escolhas</h4>
                                    <i data-feather="help-circle" class="font-medium-3 text-muted cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Porcentagem de acertos nas situações problemas do mês."></i>
                                </div>
                                <div class="card-body p-0">
                                    <input type="hidden" id="percentual" name="percentual" value="<?php echo $porcentagem; ?>">
                                    <div id="chart" class="my-2"></div>
                                    <div class="row border-top text-center mx-0">
                                        <div class="col-6 border-end py-1">
                                            <p class="card-text text-muted mb-0">Acertos</p>
                                            <h3 class="fw-bolder mb-0"><?php echo $total_acertos; ?></h3>
                                        </div>
                                        <div class="col-6 py-1">
                                            <p class="card-text text-muted mb-0">Erros</p>
                                            <h3 class="fw-bolder mb-0"><?php echo $diferenca; ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="card card-developer-meetup">
                                <div class="meetup-img-wrapper rounded-top text-center">
                                    <img src="<?= $raiz ?>app-assets/images/illustration/email.svg" alt="Meeting Pic" height="170" />
                                </div>
                                <div class="card-body">
                                    <div class="meetup-header d-flex align-items-center">
                                        <div class="meetup-day">
                                            <h6 class="mb-0">
                                            <?php

                                                // Define o locale para português do Brasil
                                                $locale = 'pt_BR';
                                         
                                                $sql = "SELECT a.*, p.nome, a.codcurso, a.periodo, a.semestre, a.codturma, ast.subturma
                                                        FROM avaliacao a
                                                          INNER JOIN problema p
                                                            ON a.id_problema = p.id_problema AND p.cod_status IS NOT NULL 
                                                          INNER JOIN avaliacao_subturma ast
                                                            ON a.id_avaliacao = ast.id_avaliacao
                                                        WHERE a.status IS NOT NULL
                                                        AND a.data_inicio >= CURDATE()
                                                        ORDER BY a.data_inicio, a.data_fim ";

                                                $stmt = mysqli_prepare($conn, $sql);

                                                mysqli_stmt_execute($stmt);

                                                $result = mysqli_stmt_get_result($stmt);

                                                $row = mysqli_fetch_array($result);

                                                if(!empty($row))
                                                {
                                                    extract($row);
                                                }

                                            ?>
                                            </h6>
                                            <h3 class="mb-0"><?php echo !empty($row['data_inicio']) ? date('d', strtotime($row['data_inicio'])) : '' ?></h3>
                                        </div>
                                        <div class="my-auto">
                                            <h4 class="card-title mb-25">Próxima Avaliação</h4>
                                            <p class="card-text mb-0"><?php echo !empty($row['nome']) ? $row['nome'] : '' ?></p>
                                        </div>
                                    </div>
                                    <div class="mt-0">
                                        <div class="avatar float-start bg-light-primary rounded me-1">
                                            <div class="avatar-content">
                                                <i data-feather="calendar" class="avatar-icon font-medium-3"></i>
                                            </div>
                                        </div>
                                        <div class="more-info">
                                            <h6 class="mb-0">
                                            <?php
                                                
                                                if(!empty($row['data_inicio']))
                                                {
                                                    // Cria um objeto IntlDateFormatter
                                                    $formatter = new IntlDateFormatter($locale, IntlDateFormatter::FULL, IntlDateFormatter::NONE, null, null, 'E, d MMM, y');

                                                    // Define a data para hoje
                                                    $data = new DateTime($row['data_inicio']);

                                                    // Formata a data
                                                    $data_formatada = $formatter->format($data);

                                                    // Converte o nome do dia da semana e do mês para maiúsculas
                                                    echo $data_formatada = ucwords($data_formatada);
                                                }
                                           ?>
                                            </h6>
                                            <small>9:00 às 12:00</small>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div class="avatar float-start bg-light-primary rounded me-1">
                                            <div class="avatar-content">
                                                <i data-feather="map-pin" class="avatar-icon font-medium-3"></i>
                                            </div>
                                        </div>
                                        <div class="more-info">
                                            <h6 class="mb-0">Sala de Tutoria 9</h6>
                                            <small>Unifeso, Alto - Teresópolis</small>
                                        </div>
                                    </div>
                                    <div class="avatar-group">
                                        <?php
                                             $sql = "SELECT e.* 
                                                    FROM pessoa e
                                                    WHERE e.cod_status = 1
                                                    ORDER BY e.nome ";

                                            $stmt = mysqli_prepare($conn, $sql);

                                            mysqli_stmt_execute($stmt);

                                            $result = mysqli_stmt_get_result($stmt);
                                        
                                            $count = 0;

                                            while($row = mysqli_fetch_array($result))
                                            {
                                                $count++;
                                                
                                                if($count == 10)
                                                {
                                                    break;  
                                                }

                                                if(!empty($row['foto']))
                                                {
                                                    $avatar = $raiz.'app-assets/images/fotos/estudante/'.$row['foto'];
                                                }
                                                else
                                                {
                                                    $avatar = $raiz."app-assets/images/portrait/small/avatar-s-{$count}.jpg";	
                                                }

                                                echo "<div data-bs-toggle='tooltip' data-popup='tooltip-custom' data-bs-placement='bottom' title='{$row['nome']}' class='avatar pull-up'>
                                                            <img src='$avatar' alt='Avatar' width='33' height='33' />
                                                        </div>";
                                            }

                                        ?>
                                        <!--h6 class="align-self-center cursor-pointer ms-50 mb-0">+42</h6-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
 
            </div>
        </div>
    </div>

    <?php 
		include('template/footer.php');
		include('template/js.php'); 
	?>

	<script src="app-assets/js/scripts/pages/dashboard-ecommerce.js"></script>
	<script>
		var options = {
			  series: [<?php echo $porcentagem; ?>],
			  chart: {
			  height: 300,
			  type: 'radialBar'
			},
			plotOptions: {
			  radialBar: {
				startAngle: -135,
				endAngle: 225,
				 hollow: {
				  margin: 0,
				  size: '70%',
				  background: '<?php echo $fill; ?>',
				  position: 'front',
				  dropShadow: {
					enabled: true,
					top: 3,
					left: 0,
					blur: 4,
					opacity: 0.24
				  }
				},
				dataLabels: {
				  show: true,
				  name: {
					offsetY: -10,
					show: true,
					color: '#888',
					fontSize: '17px'
				  },
				  value: {
					formatter: function(val) {
					  return parseInt(val)+"%";
					},
					color: '#5e5873',
					fontSize: '50px',
					show: true,
					offsetY: -5,
				  }
				}
			  }
			},
			stroke: {
			  lineCap: 'round'
			},
			labels: [''],
			};

			var chart = new ApexCharts(document.querySelector("#chart"), options);
			chart.render();
	</script>
</body>
</html>