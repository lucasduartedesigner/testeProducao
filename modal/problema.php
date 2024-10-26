<form id="form-professor" action="php/form/professor.php" method="post">
	<input type="hidden" id="status" name="status" value="1">

	<div class="modal fade text-start" id="modal-form" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Adicionar Professor</h4>
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

                        echo "<div class='col-md-12 col-12 mb-1'>";
                            echo '<label class="form-label">Nível acesso</label>';
                            require_once('php/select/nivel_acesso.php');
                        echo "</div>";
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
