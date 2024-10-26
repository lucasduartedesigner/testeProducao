<form id="form-acesso" action="php/form/nivel_acesso.php" method="post">
	<div class="modal fade text-start" id="modal-form" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Adicionar Nível de Acesso</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<?php 

							inputHidden('id_nivel_acesso');

							inputForm("col-md-12 col-12", "Nome", "nome", "", "required");
						?>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-cadastrar">Cadastrar</button>
				</div>
			</div>
		</div>
	</div>
</form>