<form id="form-senha" action="<?= $raiz ?>php/form/senha.php" method="post">
	<div class="modal fade text-start" id="modal-senha" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
		<div class="modal-dialog modal-dialog-centered modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Alterar senha</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<?php
                        
                            if(!empty($_SESSION['id_professor'])) 
                            {
                                inputHidden('id_professor', @$_SESSION['id_professor']);
                                inputHidden('tipo', 'professor');
                            }
                            else
                            {
                                inputHidden('id_estudante', @$_SESSION['id_estudante']);
                                inputHidden('tipo', 'estudante');
                            }

							inputForm("col-md-12 col-12", "Nova senha", "senha", "", "required", "", "password");
						?>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-cadastrar">Atualizar</button>
				</div>
			</div>
		</div>
	</div>
</form>