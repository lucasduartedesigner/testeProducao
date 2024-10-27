<form id="form-detalhe-obs">
	<section class="full-editor">
	  <div class="row">
		<div class="col-12">
		  <div class="card">
			<div class="card-header">
			  <h4 class="card-title">Detalhes Exames</h4>
				<?php if( $acessos[$namePage]['leitura'] == true ){ ?>
					<button type="submit" class="btn btn-outline-primary float-end" id="salvar">
						Salvar
					</button>
				<?php } ?>
				<input type="hidden" id="id_exames1" name="id_exames" value="<?php echo $id; ?>">
				<input type="hidden" id="id_detalhe_exames" name="id_detalhe_exames" value="<?php echo @$id_detalhe_exames; ?>">
				<textarea name="texto" id="texto" class="hidden"></textarea>
			</div>
			<div class="card-body">
			  <div class="row">
				<div class="col-sm-12">
				  <div id="full-wrapper">
					<div id="full-container">
						<div id="editor-container">
							  <?php echo $obs; ?>
						</div>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</section>
</form>