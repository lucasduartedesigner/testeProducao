<?php include('template/config.php'); ?>
<!DOCTYPE html>
<html class="loading" lang="pt-br">
<?php 

	$title = "Níveis de Acesso";

	include('template/head.php');

	echo "<body class='vertical-layout vertical-menu-modern navbar-floating footer-static $menu $dark' data-open='click' data-menu='vertical-menu-modern'>";

	include('template/header.php');

	include('template/menu.php');

?>

    <div class="app-content content">
        <div class="content-wrapper container-xxl p-0">
            <div class="content-body">
                <div class="row">
				<?php

					$sql = "SELECT na.id_nivel_acesso, na.nome, COUNT(p.id_pessoa) AS total
							FROM nivel_acesso na
							LEFT JOIN pessoa p ON na.id_nivel_acesso = p.id_nivel_acesso
							GROUP BY na.id_nivel_acesso
							ORDER BY na.id_nivel_acesso";

					$sql = mysqli_query($conn, $sql);

					while($row = mysqli_fetch_array($sql)){

						$id 	= $row['id_nivel_acesso'];
						$nome 	= $row['nome'];
						$total 	= $row['total'];

						echo '<div class="col-xl-4 col-lg-6 col-md-6">';
                        	echo '<div class="card">';
                            	echo '<div class="card-body">';
									echo '<div class="d-flex justify-content-between">';
										echo '<span>Usuários: ';
											echo $total;
										echo '</span>';
									echo '</div>';
									echo '<div class="d-flex justify-content-between align-items-end mt-1 pt-25">';
										echo '<div class="role-heading">';
											echo '<h4 class="fw-bolder">';
												echo $nome;
											echo '</h4>';
											if( @$acessos[$namePage]['editar'] == true ){
												echo '<a class="badge bg-primary text-white" onclick="lista('.$id.')">';
													echo '<small class="fw-bolder">Ver permissões</small>';
												echo '</a>';
											}
										echo '</div>';
										if( @$acessos[$namePage]['deletar'] == true and $id != 1 ) {
											echo "<a class='text-body deletar' data-id='$id' data-title='Nivel de acesso: $nome' data-name='nivel_acesso'>";
												echo '<i data-feather="trash" class="font-medium-5"></i>';
											echo '</a>';
										}
									echo '</div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';

					}
 
				?>
				<?php if( @$acessos[$namePage]['editar'] == true ){ ?>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="d-flex align-items-end justify-content-center h-100">
                                        <img src="app-assets/images/illustration/faq-illustrations.svg" class="img-fluid mt-2" alt="Image" width="85" />
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="card-body text-sm-end text-center ps-sm-0">
                                        <a href="javascript:void(0)" data-bs-target="#modal-form" data-bs-toggle="modal" class="stretched-link text-nowrap add-new-role">
                                            <span class="btn btn-primary mb-1">Adicionar Nível</span>
                                        </a>
                                        <p class="mb-0">Cadastre novos nível de acesso.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				<?php } ?>

                </div>
            </div>
        </div>
    </div>
 
	<input type="hidden" name="id_nivel" id="id_nivel">

    <?php
		include('modal/nivel_acesso.php');
		include('modal/menu_acesso.php');
		include('template/footer.php');
		include('template/js.php'); 
	?>

	<script>

		function lista(id)
		{

			$('#id_nivel').val(id);

			$('#tabela_menu').html("");

			$.ajax({
				type: 'POST',
				url: 'php/consulta/menu_acesso.php',
				data: { 
						id : id
					  },
				success: function(response) {

					//Insere os menus de acesso 
					$('#tabela_menu').html(response);
				}	
			});

			//Abrindo modal de menu de acesso
			$('#modalMenuAcesso').modal('show');

		}

		$(document).ready(function () {

			//Entra no evento quando marca um curso complementar
			$(document).on('change', 'input[name="menu"]', function (e) {

				var id_nivel = $('#id_nivel').val();

				//Pega os dados para enviar resposta para o banco de dados
				var checkbox = $(this);
				var id 		 = $(this).attr('id');
				var val 	 = $(this).val();

				var id_menu	 = val.split('-')[0];
				var tipo	 = val.split('-')[1];

				if(checkbox.is(':checked'))
				{
					var status = 1;
				}
				else
				{
					var status = 0;
				}

				$.ajax({
					type: 'POST',
					url: 'php/check/menu_acesso.php',
					data: { 
						   	id_nivel : id_nivel,
							id_menu	 : id_menu,
							tipo 	 : tipo,
							status   : status
						  }
				}).fail(function(jqXHR, textStatus, msg){
				 	alert(msg);
				});

			});
		});
	</script>

</body>
</html>