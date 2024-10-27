<div class="content-wrapper container-xxl p-0">
	<div class="content-body">
		<div class="row" id="table-striped">
			<div class="col-12">
				<div class="card">
					<div class="card-datatable">
						<div class="table-responsive">
							<table class="table table-striped border-bottom table-avaliacao">
								<thead>
									<tr>
										<th width="1"></th>
										<th>Caso clínico</th>
										<th>Período</th>
										<th>Turma</th>
										<th>Qtd. Pergunta</th>
										<th>Qtd. Exame</th>
										<th>Qtd. Exame Lab</th>
										<th>Status</th>
										<th width="1"></th>
									</tr>
								</thead>
								<tbody>
									<?php

                                        $cond = ($_SESSION['id_nivel_acesso'] == 2) ? " AND a.id_professor = " . $_SESSION['id_professor'] : '';

										$sql = "SELECT a.id_avaliacao, a.id_problema, a.periodo, a.data_inicio, 
                                                       a.data_fim, a.status, p.nome, 
                                                       GROUP_CONCAT(DISTINCT ast.subturma ORDER BY ast.subturma SEPARATOR '<br> ') AS subturma
                                                FROM avaliacao a
                                                  INNER JOIN problema p 
                                                    ON a.id_problema = p.id_problema 
                                                    AND p.cod_status IS NOT NULL
                                                  INNER JOIN avaliacao_subturma ast
                                                    ON a.id_avaliacao = ast.id_avaliacao
                                                  INNER JOIN avaliacao_problema pt 
                                                    ON p.id_problema = pt.id_problema
                                                    AND a.id_avaliacao = pt.id_avaliacao
                                                    AND a.codcurso = pt.codcurso
                                                    AND a.periodo = pt.periodo
                                                    AND a.semestre = pt.semestre
                                                    AND a.codturma = pt.codturma 
                                                    AND ast.subturma = pt.subturma
												WHERE pt.cod_status IS NOT NULL
                                                $cond
                                                GROUP BY a.id_avaliacao, a.id_problema, a.periodo, a.data_inicio, 
                                                         a.data_fim, a.status, p.nome
												ORDER BY a.data_inicio, a.data_fim ";

										$stmt = mysqli_prepare($conn, $sql);

										mysqli_stmt_execute($stmt);

										$result = mysqli_stmt_get_result($stmt);

										while($row = mysqli_fetch_array($result)){

											if(!empty($row))
											{
												extract($row);
											}

                                            $href = "$path?id=$id_avaliacao&pro=$id_problema&p=0";

											echo '<tr>';
												echo '<td>';
													btnEdit("href='$href'");
												echo '</td>';
												echo '<td>';
													echo $nome;
												echo '</td>';
												echo '<td>';
													echo $periodo;
												echo '</td>';
												echo '<td>';
													echo $subturma;
												echo '</td>';
												echo '<td>';
													echo $qtd_pergunta;
												echo '</td>';
												echo '<td>';
													echo $qtd_exame_fisico;
												echo '</td>';
												echo '<td>';
													echo $qtd_exame_lab;
												echo '</td>';
												echo '<td>';
													echo statusCaso($status);
												echo '</td>';
												echo '<td>';
												  if( @$acessos[$namePage]['deletar'] == true ) {
													  btnDelete($id_avaliacao, "Avaliação: $nome - $subturma", "avaliacao");
												  }
												echo '</td>';
											echo '</tr>';
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>