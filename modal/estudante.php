<form id="form-estudante" action="php/form/estudante.php" method="post">
	<input type="hidden" id="status" name="status" value="1">

	<div class="modal fade text-start" id="modal-form" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Adicionar Estudante</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row">
					<?php 

                        inputForm("col-md-8 col-12", "Nome", "nome", "", "", "", "");

                        $options = array('Ativo', 'Inativo');

                        selectOptions("col-md-4 col-12", "Status", 'status', "", $options, "");

                        inputForm("col-md-6 col-12", "Matrícula", "matricula", "", "", "", "");

                        inputForm("col-md-6 col-12", "CPF", "cpf", "", "", "cpf", "");

                        inputForm("col-md-12 col-12", "Email", "email", "", "", "email", "");

                        $options = array(13 => 'Medicina');

                        selectOptionsKey("col-md-6 col-12", "Curso", 'codcurso', $curso, $options, "");

                        $options = array(5 => '5º',  6 => '6º');

                        selectOptionsKey("col-md-6 col-12", "Período", 'periodo', @$periodo, $options, "");

                        $options = array('2024/2' => '2024/2');

                        selectOptionsKey("col-md-6 col-12", "Semestre", 'semestre', @$semestre, $options, "");

                        $options = array(
                                            'GRUPO A' => 'GRUPO A', 
                                            'GRUPO B' => 'GRUPO B',
                                            'GRUPO C' => 'GRUPO C',
                                            'GRUPO D' => 'GRUPO D',
                                            'GRUPO E' => 'GRUPO E',
                                            'GRUPO F' => 'GRUPO F',
                                            'GRUPO G' => 'GRUPO G',
                                            'GRUPO H' => 'GRUPO H',
                                        );

                        selectOptionsKey("col-md-6 col-12", "Turma", 'subturma', @$subturma, $options, "");

					?>
					</div>
				</div>
				<?php //if( @$acessos['clientes']['editar'] == true ) { ?>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary btn-cadastrar">Cadastrar</button>
					</div>
				<?php //} ?>
			</div>
		</div>
	</div>
</form>
