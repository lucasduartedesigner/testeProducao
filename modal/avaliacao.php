<form id="form-avaliacao" action="php/form/avaliacao.php" method="post">
	<input type="hidden" id="status" name="status" value="1">

	<div class="modal fade text-start" id="modal-form" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Adicionar Agendamento</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row">
					<?php 

                        inputHidden('id_avaliacao',  "");

                        require_once('php/select/problema.php');

                        selectOptionsKey("col-md-12 col-12", "Caso clínico", 'id_problema', "", $arrayProblema, "");
                        
                        require_once('php/select/professor.php');

                        selectOptionsKey("col-md-12 col-12", "Professor", 'id_professor', "", $arrayProfessor, "");

                        inputForm("col-md-6 col-12", "Dt. Avaliação", "data_inicio", "", "required autocomplete='off'", "data", "");

                        inputForm("col-md-6 col-12", "Dt. Grupo", "data_grupo", "", "required autocomplete='off'", "data", "");

                        inputForm("col-md-6 col-12", "Dt. Turma", "data_turma", "", "required autocomplete='off'", "data", "");

                        $options = array('Agendado', 'Em avaliação', 'Finalizado', 'Cancelado');

                        selectOptions("col-md-6 col-12", "Status", 'status', "", $options, "");

                        $options = array(13 => 'Medicina');

                        selectOptionsKey("col-12", "Curso", 'codcurso', "", $options, "required");

                        $options = array(5 => '5º',  6 => '6º');

                        selectOptionsKey("col-md-6 col-12", "Período", 'periodo', "", $options, "required");

                        $options = array('2024/2' => '2024/2');

                        selectOptionsKey("col-md-6 col-12", "Semestre", 'semestre', "", $options, "required");

                        $optionsG = array(
                                            'GRUPO A' => 'GRUPO A', 
                                            'GRUPO B' => 'GRUPO B',
                                            'GRUPO C' => 'GRUPO C',
                                            'GRUPO D' => 'GRUPO D',
                                            'GRUPO E' => 'GRUPO E',
                                            'GRUPO F' => 'GRUPO F',
                                            'GRUPO G' => 'GRUPO G',
                                            'GRUPO H' => 'GRUPO H',
                                        );

					?>
                        <div class="col-12">
                            <label class="form-label" for="default-select-multi">Turma</label>
                            <div class="mb-1">
                                <select class="select2 form-select" id="subturma" name="subturma[]" multiple="multiple" data-placeholder="Selecione um Grupo" required>
                                    <?php
                                    
                                        foreach($optionsG as $grupo)
                                        {
                                          echo "<option value='$grupo'>$grupo</option>";
                                        }

                                    ?>
                                </select>
                            </div>
                        </div>
					</div>
				</div>
				<?php if( @$acessos[$namePage]['editar'] == true ) { ?>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary btn-cadastrar">Cadastrar</button>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</form>