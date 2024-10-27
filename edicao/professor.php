<div class="content-wrapper container-xxl p-0">
	<div class="content-body">
		<section class="app-user-view-account">
            <div class="card">
                <h4 class='card-header'>Dados</h4>
                <div class="card-body">
                    <form id="form-professor" action="php/form/professor.php" method="post">
                        <div class="row">
                            <?php 

                                inputHidden('id_professor', $id_professor);

                                inputForm("col-md-12 col-12", "Nome", "nome", $nome, "", "", "");

                                inputForm("col-md-4 col-12", "Matrícula", "matricula", $matricula, "", "", "");

                                inputForm("col-md-4 col-12", "CPF", "cpf", $cpf, "", "cpf", "");

                                $options = array('Ativo', 'Inativo');

                                selectOptions("col-md-4 col-12", "Status", 'status', $status, $options, "");

                                inputForm("col-md-5 col-12", "Email", "email", $email, "", "email", "");

                                echo "<div class='col-md-3 col-12 mb-1'>";
                                    echo '<label class="form-label">Nível acesso</label>';
                                    require_once('php/select/nivel_acesso.php');
                                echo "</div>";

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