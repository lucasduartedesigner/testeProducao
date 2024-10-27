<?php include('template/config.php'); ?>
<!DOCTYPE html>
<html class="loading" lang="pt-br">
<?php 

	$title = "Prontuário dos Grupos";

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
			if(!empty($_GET['id']) && !empty($_GET['pro']))
			{
				$id_avaliacao = $_GET['id'];
				$id_problema  = $_GET['pro'];

				include_once('edicao/resultado.php');
                
                include_once('modal/pergunta_turma.php');
			}
			else 
			{
				include_once('lista/resultado.php');
			}
		?>
    </div>

    <?php 
		include('template/footer.php'); 
		include('template/js.php'); 
		include('template/js/functions.php');
	?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

	<script>
        // Função para gerar PDF dinâmico com texto selecionável
        function generatePDF(id) {
            // Seleciona o conteúdo da div específica
            var element = document.getElementById('content-pdf-' + id);

            // Pega o título para ser usado como nome do arquivo
            var title = document.querySelector('.title-pdf-' + id).innerText.trim();

            // Esconde o botão antes de gerar o PDF
            var button = document.getElementById('btn-pdf-' + id);
            button.style.display = 'none';

            // Esconde todos os botões com a classe 'btn-outline-primary'
            $('.btn-outline-primary').addClass('d-none');

            var opt = {
                margin: 0, // Remove todas as margens
                filename: title + '.pdf', // Nome do arquivo baseado no título
                html2canvas: { scale: 2 }, // Escala de renderização
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
                pagebreak: { mode: ['avoid-all', 'css', 'legacy'] } // Evita quebras de página desnecessárias
            };

            // Gera o PDF com texto selecionável (não como imagem)
            html2pdf().set(opt).from(element).save().then(function() {
                // Após o PDF ser gerado, mostra o botão novamente
                button.style.display = 'inline-block';

                // Mostra novamente os botões com a classe 'btn-outline-primary'
                $('.btn-outline-primary').removeClass('d-none');
            });
        }

        // Evento para capturar clique nos botões de download
        document.querySelectorAll('.download-pdf').forEach(button => {
            button.addEventListener('click', function() {
                var id = this.getAttribute('data-id');
                generatePDF(id);
            });
        });

        function openFileModal(fileUrl, fileType) 
        {
            let content = '';

            if (fileType === 'image')
            {
                content = `<img src="${fileUrl}" class="img-fluid" alt="Imagem">`;
            } 
            else if (fileType === 'video')
            {
                content = `<video controls class="w-100" style="max-height: 400px;">
                              <source src="${fileUrl}" type="video/mp4">
                           </video>`;
            } 
            else if (fileType === 'audio')
            {
                content = `<audio controls class="w-100">
                              <source src="${fileUrl}" type="audio/mp3">
                           </audio>`;
            }

            $('#modalFileContent').html(content);
        }


		$('.table-avaliacao thead tr').clone(true).addClass('filters').appendTo('.table-avaliacao thead');

		$(document).ready(function () {	

            $('#id_pergunta').change(function () {	

                var value = $(this).val()
                
                console.log(value)
                
                if(value == "")
                {
                    //$('#resposta').val("");
                    $('.div-resposta').show();
                }
                else
                {
                    $('.div-resposta').hide();
                }
            })

			$('.table-avaliacao').DataTable({
				orderCellsTop: true,
				fixedHeader: true,
				initComplete: function () {

					var api = this.api();

					api.columns().eq(0).each(function (i, colIdx) {

						var cell = $('.filters th').eq(
							$(api.column(colIdx).header()).index()
						);

						var title = $(cell).text();

						if (i === 0 || i === 8)
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
				"order": [[ 4, "asc" ]],
                "pageLength": 50,
				columnDefs: [
					{ orderable: false, targets: 0 },
					{ orderable: false, targets: 8 }
				],
				dom: 'Blfrtip',
				buttons: [
					{
						extend: 'excelHtml5',
						text: '<i class="far fa-file-excel"></i>',
						className: 'btn btn-outline-primary mb-1 mt-1 me-1 waves-effect float-end',
						exportOptions: {
							columns: [ 1, 2, 3, 4, 5, 6, 7 ]
						}
					},
					{
						extend: 'pdfHtml5',
						text: '<i class="far fa-file-pdf"></i>',
          				className: 'btn btn-outline-primary mb-1 mt-1 me-1 waves-effect float-end',
						exportOptions: {
							columns: [ 1, 2, 3, 4, 5, 6, 7 ]
						}
					}
				]
			});

		});
	</script>
</body>
</html>