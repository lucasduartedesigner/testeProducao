<div class="card">
	<h4 class='card-header'>Logo</h4>
	<div class="card-body">
		<?php

			if(!empty($foto))
			{

				$uploaddir = "{$raiz}app-assets/images/logo/$foto";

				echo "<div class='row d-flex justify-content-center'>";
					echo "<div class='col-12 col-md-4 mt-4 mb-5 pb-3 text-center'>";
						echo "<img class='w-100' src='$uploaddir'>";
						if( $acessos[$namePage]['deletar'] == true ) { 
							echo "<button class='btn btn-danger mt-4 deleta-img' id='logo' data-title='Logo: $nome' data-id='$id_clinica' data-name='clinica'>";
								echo "<i data-feather='trash-2'></i> Deletar";
							echo "</button>";
						}
					echo "</div>";
				echo "</div>";
			}
			else
			{
				echo "<form action='php/envio/logo.php?id=$id_clinica' class='dropzone dropzone-area' id='dpz-single-file'>";
					echo "<div class='dz-message'>Envie sua logo para relatórios!</div>";
				echo "</form>";
			}

		?>
	</div>
</div>