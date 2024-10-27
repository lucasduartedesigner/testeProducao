<?php include('template/config.php'); ?>
<!DOCTYPE html>
<html class="loading" lang="pt-br">
<?php 

	$title = "Caso clínico";

	include('template/head.php');

	echo "<style>
			#DataTables_Table_0_info, #DataTables_Table_0_paginate{
				width: 50%;
				float: left;
			}
            .icon-wrapper .feather {
                height: 80px;
                width: 80px;
            }
            .body-container {
                position: relative;
                display: inline-block;
                width: 100%; /* Ajusta o tamanho do contêiner para 100% da largura da imagem */
            }
            .marker {
                position: absolute;
                width: 20px;
                height: 20px;
                background-color: #0D899E;
                border-radius: 50%;
                cursor: pointer;
            }
            .marker-red{
                position: absolute;
                width: 20px;
                height: 20px;
                background-color: #ea5455;
                border-radius: 50%;
                cursor: pointer;
            }

		 </style>";
    
    echo "<link rel='stylesheet' href='{$raiz}app-assets/css/plugins/extensions/ext-component-drag-drop.css'>";

	echo "<body class='vertical-layout vertical-menu-modern navbar-floating footer-static $menu $dark' data-open='click' data-menu='vertical-menu-modern'>";

	include('template/header.php');

	include('template/menu.php');

?>

    <div class="app-content content">
 		<?php

			if(!empty($_GET['p']))
			{
                unset($nome);

                if(!empty($_GET['id']))
			    {
                    $id_problema = $_GET['id'];

                    $sql = "SELECT p.*
                            FROM problema p
                            WHERE id_problema = ? ";

                    $stmt = mysqli_prepare($conn, $sql);

                    mysqli_stmt_bind_param($stmt, "s", $id_problema);
                    mysqli_stmt_execute($stmt);

                    $result = mysqli_stmt_get_result($stmt);
                    $row    = mysqli_fetch_array($result);

                    if(!empty($row))
                    {
                        extract($row);
                    }
                }

				include_once('edicao/problema.php');
                
                if($_GET['p'] == 2)
                {
                    include_once('modal/exame_fisico.php');
                }
                elseif($_GET['p'] == 3)
                {
                    include_once('modal/exame_laboratorial.php');
                }
                
			}
			else 
			{
				include_once('lista/problema.php');
			}
		?>
    </div>

    <?php 
		include('template/footer.php');
		include('template/js.php');
		include('template/js/assinatura.php');
		include('template/js/functions.php');
	?>

	<script>
        $(document).ready(function() {

            let currentMarker = null;

            // Inicializa tooltips do Bootstrap
            $('[data-toggle="tooltip"]').tooltip();

            // Mostrar informação no modal ao clicar na marcação
            $(document).on('click', '.marker-red', function() {
                $('#cabeca').modal('toggle');
            })

            $(document).on('click', '.marker', function() {

                var id_exame_fisico = $(this).attr('data-id');

                editarExameFisico(id_exame_fisico);

                $('#id_exame_fisico').val(id_exame_fisico);

            });

            // Funções para visualizar arquivos
            function isImage(fileType) {
                var imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                return imageTypes.includes(fileType);
            }

            function isVideo(fileType) {
                var videoTypes = ['mp4', 'webm', 'ogg', 'avi', 'mov', 'wmv', 'flv', 'mkv'];
                return videoTypes.includes(fileType);
            }

            function isAudio(fileType) {
                var audioTypes = ['mp3', 'wav', 'ogg', 'm4a', 'flac', 'aac'];
                return audioTypes.includes(fileType);
            }

            function visualizarArquivo(filePath) {
                var filePreview = $('#file-preview');
                var fileURL = filePath;
                var fileName = fileURL.split('/').pop();
                var fileType = fileName.split('.').pop().toLowerCase();

                filePreview.empty(); 

                if (isImage(fileType)) {
                    var imgElement = $('<img>', {
                        src: fileURL,
                        class: 'img-fluid rounded-bottom',
                        style: 'max-height: 400px; cursor: pointer;',
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#imageModal'
                    });

                    filePreview.append(imgElement);

                    imgElement.on('click', function() {
                        $('#modalImage').attr('src', fileURL);
                    });

                } else if (isVideo(fileType)) {
                    filePreview.append('<video controls style="width:100%"><source src="' + fileURL + '" type="video/' + fileType + '"></video>');

                } else if (isAudio(fileType)) {
                    filePreview.append('<audio controls style="width:100%"><source src="' + fileURL + '" type="audio/' + fileType + '"></audio>');

                } else if (fileType === 'pdf') {
                    filePreview.append('<embed src="' + fileURL + '" type="application/pdf" width="100%" height="400px" />');

                } else {
                    filePreview.append('<p>Arquivo selecionado não pode ser visualizado.</p>');
                }
            }

            // Resetar o formulário ao fechar o modal
            $('#modal-exame-fisico').on('hidden.bs.modal', function () {

                $('#form-problema')[0].reset();

                $('#id_exame_fisico').val('');

                $('#removeMarker').hide();

                $('#file-preview').html("");

                currentMarker = null;
            });

            $('#modal-exame-laboratorial').on('hidden.bs.modal', function () {
                
                $('#form-laboratorial')[0].reset();

                $('#id_exame_laboratorial').val('');

                $('#file-preview').html("");
            });

        });

        var imageModalTriggered = false;
        
        <?php if( @$acessos[$namePage]['editar'] == true ) { ?>
        function salvarOrdem(data) 
        {
            $.ajax({
                url: 'php/edita/ordem_pergunta.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) 
                {
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    console.error(textStatus, errorThrown);
                }
            });
        }

        $(function () {
          'use strict';

          dragula([document.getElementById('basic-list-group')])
          .on('drop', function (el) {

                let items = document.querySelectorAll('#basic-list-group .list-group-item');
                let data = [];

                items.forEach((item, index) => {
                    let id_pergunta = item.getAttribute('data-id');
                    let ordem =  index + 1

                    data.push({
                        id_pergunta: id_pergunta,
                        ordem: ordem
                    });
               });
              
               salvarOrdem(data); 
          });
        });
        <?php } ?>
        
        function isImage(fileType) 
        {
            var imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
            return imageTypes.includes(fileType);
        }

        function isVideo(fileType) 
        {
            var videoTypes = ['mp4', 'webm', 'ogg', 'avi', 'mov', 'wmv', 'flv', 'mkv'];
            return videoTypes.includes(fileType);
        }

        function isAudio(fileType) 
        {
            var audioTypes = ['mp3', 'wav', 'ogg', 'm4a', 'flac', 'aac'];
            return audioTypes.includes(fileType);
        }

        function visualizarArquivo(filePath) 
        {
            var filePreview = $('#file-preview');
            var fileURL = filePath;
            var fileName = fileURL.split('/').pop();
            var fileType = fileName.split('.').pop().toLowerCase();

            filePreview.empty(); 

            if (isImage(fileType)) 
            {
                var imgElement = $('<img>', {
                    src: fileURL,
                    class: 'img-fluid rounded-bottom',
                    style: 'max-height: 400px; cursor: pointer;',
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#imageModal'
                });

                filePreview.append(imgElement);

                imgElement.on('click', function() {
                    $('#modalImage').attr('src', fileURL);
                });

            } 
            else if (isVideo(fileType)) 
            {
                filePreview.append('<video controls style="width:100%"><source src="' + fileURL + '" type="video/' + fileType + '"></video>');

            }
            else if (isAudio(fileType)) 
            {
                filePreview.append('<audio controls style="width:100%"><source src="' + fileURL + '" type="audio/' + fileType + '"></audio>');

            } 
            else if (fileType === 'pdf') 
            {
                filePreview.append('<embed src="' + fileURL + '" type="application/pdf" width="100%" height="400px" />');

            } 
            else
            {
                filePreview.append('<p>Arquivo selecionado não pode ser visualizado.</p>');
            }
        }

        function editarExameFisico(id) 
        {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'php/consulta/exame_fisico.php',
                async: true,
                data: { id: id },
                success: function(response) {

                    // Preenche inputs com dados
                    $.each(response, function(index, item) {
                        $("#" + index).val(item);
                    });

                    if (response['dir']) 
                    {
                        visualizarArquivo(response['dir']);
                    }

                    // Ajusta os títulos para edição
                    $('.modal-title').html("Editar Exame Fisico");
                    $('.btn-cadastrar').html("Alterar");

                    // Abre o modal
                    $('#modal-exame-fisico').modal('toggle');
                }
            });
        }

        function editarExameLaboratorial(id) 
        {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'php/consulta/exame_laboratorial.php',
                async: true,
                data: { id: id },
                success: function(response) {

                    // Preenche inputs com dados
                    $.each(response, function(index, item) {
                        $("#" + index).val(item);
                    });

                    if (response['dir']) 
                    {
                        visualizarArquivo(response['dir']);
                    }
                    
                    $('#valor').val(money(response['valor']));

                    // Ajusta os títulos para edição
                    $('.modal-title').html("Editar Exame Laboratorial");
                    $('.btn-cadastrar').html("Alterar");

                    // Abre o modal
                    $('#modal-exame-laboratorial').modal('toggle');
                }
            });
        }

        $('#imageModal').on('show.bs.modal', function () {

            imageModalTriggered = true;

            if ($('#new-task-modal').length)
            {
                $('#new-task-modal').modal('hide');
            }
        });

        // Reabrir #new-task-modal ao fechar #imageModal
        $('#imageModal').on('hidden.bs.modal', function () {
            if ($('#new-task-modal').length) 
            {
                $('#new-task-modal').modal('show');
            }
        });

        $('#form-problema').on('hidden.bs.modal', function () {
            if (!imageModalTriggered) 
            {
                $('#form-problema')[0].reset();
                $('#id_pergunta').val("");
                $('#id_resposta').val("");
                $('#file-preview').html("");
                $('#modalImage').attr("src", "");
                $("#gabarito").prop("checked", false)
            }

            imageModalTriggered = false;
        })

        $(document).ready(function () {

          $('#file-input').on('change', function (e) {

            var file        = e.target.files[0];
            var filePreview = $('#file-preview');
            var reader      = new FileReader();

            filePreview.empty(); 

            reader.onload = function (e) {

              var fileURL  = e.target.result;
              var fileType = file.type;

              if (fileType.startsWith('image/'))
              {
                var imgElement = $('<img>', {
                  src: fileURL,
                  class: 'img-fluid rounded-bottom',
                  style: 'max-height: 400px; cursor: pointer;',
                  'data-toggle': 'modal',
                  'data-target': '#imageModal'
                });

                filePreview.append(imgElement);

                imgElement.on('click', function() {
                  $('#modalImage').attr('src', fileURL);
                });

              } 
              else if (fileType.startsWith('video/'))
              {
                filePreview.append('<video controls style="width:100%"><source src="' + fileURL + '" type="' + fileType + '"></video>');
              } 
              else if (fileType.startsWith('audio/')) 
              {
                filePreview.append('<audio controls style="width:100%"><source src="' + fileURL + '" type="' + fileType + '"></audio>');
              } 
              else if (fileType === 'application/pdf') 
              {
                filePreview.append('<embed src="' + fileURL + '" type="application/pdf" width="100%" height="400px" />');
              } 
              else 
              {
                filePreview.append('<p>Arquivo selecionado não pode ser visualizado.</p>');
              }
            };

            reader.readAsDataURL(file);

            $('.icon-wrapper').hide();

            $('label[for="file-input"]').removeClass('p-5').addClass('p-1');
          });
        });

		$('.table-funcionarios thead tr').clone(true).addClass('filters').appendTo('.table-funcionarios thead');

		$(document).ready(function () {	

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

						if (i === 0 || i === 4)
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
					{ orderable: false, targets: 4 }
				],
				dom: 'Blfrtip',
				buttons: [
					{
						extend: 'excelHtml5',
						text: '<i class="far fa-file-excel"></i>',
						className: 'btn btn-outline-primary mb-1 mt-1 me-1 waves-effect float-end',
						exportOptions: {
							columns: [ 1, 2, 3]
						}
					},
					{
						extend: 'pdfHtml5',
						text: '<i class="far fa-file-pdf"></i>',
          				className: 'btn btn-outline-primary mb-1 mt-1 me-1 waves-effect float-end',
						exportOptions: {
							columns: [ 1, 2, 3 ]
						}
					},
					<?php if( @$acessos[$namePage]['editar'] == true ) { ?>
					{
						text: '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Adicionar',
						className: 'btn btn-outline-primary mb-1 mt-1 me-1 waves-effect float-end ',
						action: function (e, node, config){ window.location.href = 'problema.php?p=1 ' }
					}
					<?php } ?>
				]
			});

		});

	</script>
</body>
</html>