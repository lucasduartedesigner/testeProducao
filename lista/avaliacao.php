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
										<th>Dt. Inicio</th>
										<th>Dt. Fim</th>
										<th>Status</th>
										<th width="1"></th>
									</tr>
								</thead>
								<tbody>
									<?php
                                    
                                        $cond = ($_SESSION['id_nivel_acesso'] == 2) ? " AND a.id_professor = " . $_SESSION['id_professor'] : '';

										$sql = "SELECT a.*, p.nome, 
                                                       GROUP_CONCAT(ast.subturma ORDER BY ast.subturma SEPARATOR '<br> ') AS subturma
                                                FROM avaliacao a
                                                INNER JOIN problema p
                                                    ON a.id_problema = p.id_problema AND p.cod_status IS NOT NULL 
                                                INNER JOIN avaliacao_subturma ast
                                                    ON a.id_avaliacao = ast.id_avaliacao
                                                WHERE a.status IS NOT NULL
                                                $cond
                                                GROUP BY a.id_avaliacao
                                                ORDER BY a.data_inicio, a.data_fim";

										$stmt = mysqli_prepare($conn, $sql);

										mysqli_stmt_execute($stmt);

										$result = mysqli_stmt_get_result($stmt);

										while($row = mysqli_fetch_array($result)){

											if(!empty($row))
											{
												extract($row);
											}

											echo '<tr>';
												echo '<td>';
													btnEdit("onClick='editar($id_avaliacao)'");
												echo '</td>';
												echo '<td>';
													echo $nome;
												echo '</td>';
												echo '<td class="text-center">';
													echo $periodo;
												echo '</td>';
												echo '<td class="text-center">';
													echo $subturma;
												echo '</td>';
												echo '<td class="text-center">';
													echo dataBR($data_inicio);
												echo '</td class="text-center">';
												echo '<td>';
													echo dataBR($data_fim);
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