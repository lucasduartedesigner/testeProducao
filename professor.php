<?php include('template/config.php'); ?>
<!DOCTYPE html>
<html class="loading" lang="pt-br">
<?php 

	$title = "Professor";

	include('template/head.php');

	echo "<style>
			#DataTables_Table_0_info, #DataTables_Table_0_paginate{
				width: 50%;
				float: left;
			}
		 </style>";

	echo "<body class='vertical-layout vertical-menu-modern navbar-floating footer-static $menu $dark' data-open='click' data-menu='vertical-menu-modern'>";

	include('template/header.php');

	include('template/menu.php');

?>

    <div class="app-content content">
 		<?php
			if(!empty($_GET['user']))
			{
				$id_professor = $_GET['user'];

				$sql = "SELECT * FROM professor
						WHERE id_professor = ? ";

				$stmt = mysqli_prepare($conn, $sql);

				mysqli_stmt_bind_param($stmt, "s", $id_professor);
				mysqli_stmt_execute($stmt);

				$result = mysqli_stmt_get_result($stmt);
				$row    = mysqli_fetch_array($result);

				if(!empty($row))
				{
					extract($row);
				}

				include_once('edicao/professor.php');
			}
			else 
			{
				include_once('lista/professor.php');
				include_once('modal/professor.php'); 
			}
		?>
    </div>

    <?php 
		include('template/footer.php'); 
		include('template/js.php'); 
		include('template/js/functions.php');
	?>

	<script>

		$('.table-funcionarios thead tr').clone(true).addClass('filters').appendTo('.table-funcionarios thead');

		$(document).ready(function () {	

			//Inicia tabela inteligente
			$('.table-funcionarios').DataTable({
				orderCellsTop: true,
				fixedHeader: true,
				initComplete: function () {

					var api = this.api();

					api.columns().eq(0).each(function (i, colIdx) {

						var cell = $('.filters th').eq(
							$(api.column(colIdx).header()).index()
						);

						var title = $(cell).text();

						if (i === 0 || i === 6)
						{
							$(cell).html('');
						}
						else
						{
							$(cell).html('<input type="text" class="form-control form-control-sm" placeholder="' + title + '" />');
						}

						$('input', $('.filters th').eq($(api.column(colIdx).header()).index())).off('keyup change').on('change', function (e) {

							$(this).attr('title', $(this).val());

							var regexr = '({search})'; 

							var cursorPosition = this.selectionStart;

							api.column(colIdx).search(
									this.value != ''
										? regexr.replace('{search}', '(((' + this.value + ')))')
										: '',
									this.value != '',
									this.value == ''
								).draw();

						}).on('keyup', function (e) {

							e.stopPropagation();

							var cursorPosition = this.selectionStart;

							$(this).trigger('change');
							$(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
						});
					});
				},
				"language": {
					"url": "app-assets/vendors/js/pagination/pt-BR.json"
				},
				"order": [[ 1, "asc" ]],
                "pageLength": 50,
				columnDefs: [
					{ orderable: false, targets: 0 },
					{ orderable: false, targets: 6 }
				],
				dom: 'Blfrtip',
				buttons: [
					{
						extend: 'excelHtml5',
						text: '<i class="far fa-file-excel"></i>',
						className: 'btn btn-outline-primary mb-1 mt-1 me-1 waves-effect float-end',
						exportOptions: {
							columns: [ 1, 2, 3, 4 ]
						}
					},
					{
						extend: 'pdfHtml5',
						text: '<i class="far fa-file-pdf"></i>',
          				className: 'btn btn-outline-primary mb-1 mt-1 me-1 waves-effect float-end',
						exportOptions: {
							columns: [ 1, 2, 3, 4 ]
						}
					},
					<?php if( @$acessos[$namePage]['editar'] == true ) { ?>
					{
						text: '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Adicionar',
						className: 'btn btn-outline-primary mb-1 mt-1 me-1 waves-effect float-end ',
						action: function (e, node, config){ $('#modal-form').modal('show') }
					}
					<?php } ?>
				]
			});

		});
	</script>
</body>
</html>