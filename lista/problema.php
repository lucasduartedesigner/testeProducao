<div class="content-wrapper container-xxl p-0">
	<div class="content-body">
		<div class="row" id="table-striped">
			<div class="col-12">
				<div class="card">
					<div class="card-datatable">
						<div class="table-responsive">
							<table class="table table-striped border-bottom table-funcionarios">
								<thead>
									<tr>
										<th width="1"></th>
										<th>Nome</th>
										<th>Avaliações</th>
										<th>Status</th>
										<th width="1"></th>
									</tr>
								</thead>
								<tbody>
									<?php

										$sql = "SELECT p.id_problema, p.nome, p.cod_status,
                                                       COALESCE(COUNT(a.id_avaliacao), 0) AS qtd_avaliacao
                                                FROM problema p
                                                LEFT JOIN avaliacao a 
                                                    ON p.id_problema = a.id_problema
                                                    AND a.status IS NOT NULL
                                                WHERE p.cod_status IS NOT NULL
                                                GROUP BY p.id_problema, p.nome, p.cod_status
                                                ORDER BY p.nome ";

										$stmt = mysqli_prepare($conn, $sql);

										mysqli_stmt_execute($stmt);

										$result = mysqli_stmt_get_result($stmt);

										while($row = mysqli_fetch_array($result)){

											if(!empty($row))
											{
												extract($row);
											}
                                            
                                            $status = !empty($status) ? 'Ativo' : 'Inativo';

											$href = "$path?id=$id_problema&p=1";

											echo '<tr>';
												echo '<td>';
													btnEdit("href='$href'");
												echo '</td>';
												echo '<td>';
													echo $nome;
												echo '</td>';
												echo '<td class="text-center">';
													echo @$qtd_avaliacao;
												echo '</td>';
												echo '<td>';
													echo $status;
												echo '</td>';
												echo '<td>';
												  if( @$acessos[$namePage]['deletar'] == true ) {
													  btnDelete($id_problema, "Problema: $nome", "problema");
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