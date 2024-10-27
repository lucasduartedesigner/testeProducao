<div class="card">
	<h4 class='card-header'>Foto</h4>
	<div class="card-body">
		<?php

			if(!empty($foto))
			{
				$nome = $nome ?? '';

				$uploaddir = "app-assets/images/fotos/$foto";

				echo "<div class='row d-flex justify-content-center'>";
					echo "<div class='col-12 col-md-3 mt-4 mb-5 pb-3 text-center'>";
						echo "<img class='w-100 rounded-circle' src='$uploaddir'>";
						if( $acessos[$namePage]['deletar'] == true ) { 
							echo "<button class='btn btn-danger mt-3 deleta-img' id='fotos' data-title='Foto: $nome' data-id='$id_pessoa' data-name='pessoa'>";
								echo "<i data-feather='trash-2'></i> Deletar";
							echo "</button>";
						}
					echo "</div>";
				echo "</div>";
			}
			else
			{
				echo "<form action='php/envio/fotos.php?id=$id_pessoa' class='dropzone dropzone-area' id='dpz-single-file'>";
					echo "<div class='dz-message'>Envie sua foto para relatórios!</div>";
				echo "</form>";
			}

		?>
	</div>
</div>