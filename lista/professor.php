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
										<th>Matrícula</th>
										<th>CPF</th>
										<th>Email</th>
										<th>Nivel Acesso</th>
										<th width="1"></th>
									</tr>
								</thead>
								<tbody>
									<?php

										$sql = "SELECT p.*, na.nome nivel_acesso
                                                FROM professor p
                                                INNER JOIN nivel_acesso na ON na.id_nivel_acesso = p.id_nivel_acesso
												WHERE p.status IN (1, 2) 
												ORDER BY p.nome";

										$stmt = mysqli_prepare($conn, $sql);

										mysqli_stmt_execute($stmt);

										$result = mysqli_stmt_get_result($stmt);

										while($row = mysqli_fetch_array($result)){

											if(!empty($row))
											{
												extract($row);
											}

											$href = "$path?url=$url&user=$id_professor";

											echo '<tr>';
												echo '<td>';
													btnEdit("href='$href'");
												echo '</td>';
												echo '<td>';
													echo $nome;
												echo '</td>';
												echo '<td>';
													echo $matricula;
												echo '</td>';
												echo '<td>';
													echo formatarCPF($cpf);
												echo '</td>';
												echo '<td>';
													echo $email;
												echo '</td>';
												echo '<td>';
													echo $nivel_acesso;
												echo '</td>';
												echo '<td>';
												  if( @$acessos[$namePage]['deletar'] == true ) {
													  btnDelete($id_professor, "Professor: $nome", "professor");
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