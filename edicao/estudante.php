<div class="content-wrapper container-xxl p-0">
	<div class="content-body">
		<section class="app-user-view-account">
            <div class="card">
                <h4 class='card-header'>Dados</h4>
                <div class="card-body">
                    <form id="form-estudante" action="php/form/estudante.php" method="post">
                        <div class="row">
                            <?php 

                                inputHidden('id_estudante', $id_estudante);

                                inputForm("col-md-12 col-12", "Nome", "nome", $nome, "", "", "");

                                inputForm("col-md-4 col-12", "Matrícula", "matricula", $matricula, "", "", "");

                                inputForm("col-md-4 col-12", "CPF", "cpf", $cpf, "", "cpf", "");

                                $options = array('Ativo', 'Inativo');

                                selectOptions("col-md-4 col-12", "Status", 'status', $status, $options, "");

                                $options = array(13 => 'Medicina');

                                selectOptionsKey("col-md-3 col-12", "Curso", 'codcurso', $curso, $options, "");

                                $options = array(5 => '5º',  6 => '6º');

                                selectOptionsKey("col-md-3 col-12", "Período", 'periodo', @$periodo, $options, "");

                                $options = array('2024/2' => '2024/2');

                                selectOptionsKey("col-md-3 col-12", "Semestre", 'semestre', @$semestre, $options, "");

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

                                selectOptionsKey("col-md-3 col-12", "Turma", 'subturma', @$subturma, $options, "");

                                inputForm("col-md-8 col-12", "Email", "email", $email, "", "email", "");

                                $checked = ($reset == 1) ? 'checked' : '';

                                inputswitch("col-md-4 col-12 d-flex justify-content-between pt-2", "Resetar a senha", "reset", "1", $checked);


                            ?>
                        </div>
                        <?php
                            if( $acessos[$namePage]['editar'] == true )
                            {
                                echo '<button type="submit" class="btn btn-primary btn-cadastrar mt-2">Alterar</button>';
                            }
                        ?>
                    </form>
                </div>
            </div>
		</section>
	</div>
</div>