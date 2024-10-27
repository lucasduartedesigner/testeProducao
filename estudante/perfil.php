<?php

	//Inicia sessão
    session_start();

    $url = !empty($_GET['url']) ? $_GET['url'] : 0;

    $itens = array('Perfil', 'Agenda', 'Discussão do Caso');
    $icos  = array('user', 'calendar', 'file-text');

	$title = $itens[$url];

	$raiz = "../";

	//Incluindo a conexão com banco de dados   
    include_once("{$raiz}conn/conn.php");

	//Inclui funções
    include_once("{$raiz}php/function/db.php");

	//Altera o timezone para pt-br
	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Sao_Paulo');

	$return = 0;

	//Verifica se fez login
	if(empty($_SESSION['id_estudante']))
	{
		if(empty($_COOKIE['login']))
		{
			$_SESSION['loginErro'] = "Você precisa fazer login para acessar o sistema!";

			header("Location: {$raiz}index.php");

			$return = 1;
		}
		else
		{
			$user = $_COOKIE['login'];

			//Inclui o arquivo com a function de validação de usuario
			require_once("{$raiz}php/function/valida.php");

			sessionDadosUsuario($conn, $user);
		}
	}
	else
	{
		$id_estudante = $_SESSION['id_estudante'];
	}

	$id_config = 1;

	$sql = "SELECT name, site, description, logo, icone
            FROM config WHERE id_config = ? ";

	$stmt = mysqli_prepare($conn, $sql);

	mysqli_stmt_bind_param($stmt, "i", $id_config);
	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);
	$row    = mysqli_fetch_array($result);

	if(!empty($row))
	{
		extract($row);
	}
?>
<!DOCTYPE html>
<html class="loading" lang="pt-br">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">

    <meta name="description" content="Aplicativo <?= $name ?> - <?= $description ?>">
    <meta name="author" content="Lucas Duarte">

    <title>App <?= $name ?> - <?= $description ?></title>
    <link rel="apple-touch-icon" href="<?= $raiz ?><?= $icone ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= $raiz ?><?= $icone ?>">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
    
    <style>
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
    </style>

    <?php include_once("{$raiz}template/css.php"); ?>

	<?php if($return == 1){	?>
		<script>
			window.location.replace("<?= $raiz ?>index.php");
		</script>
	<?php } ?>
</head>
<?php

	//Define o nome do arquivo acessado
	$ArrPATH  = explode("/",$_SERVER['SCRIPT_NAME']);
	$path 	  = $ArrPATH[count($ArrPATH)-1];
	$namePage = str_replace(".php" , "", $path);

	//Configura modo escuro
	if(@$_SESSION['estilo'] == 1)
	{
		$dark = "dark-layout";
		$fill = "#283046";
		$mark = "#343D55";
		$icon = "sun";
	}
	else
	{
		$dark = "";
		$fill = "#ffffff";		
		$mark = "#f3f2f7";		
		$icon = "moon";		
	}

	//Configura menu icone
	//$menu = (!empty($_SESSION['menu']) && $_SESSION['menu'] == 1) ? " menu-collapsed" : "";
    $menu =  " menu-collapsed";

	echo "<body class='vertical-layout vertical-menu-modern navbar-floating footer-static $menu $dark' data-open='click' data-menu='vertical-menu-modern'>";

	include("template/header.php");

	include("template/menu.php");

	$id_estudante = $_SESSION['id_estudante'];

	$sql = "SELECT e.*
			FROM estudante e
			WHERE e.id_estudante = ? ";
    
	$stmt = mysqli_prepare($conn, $sql);

	mysqli_stmt_bind_param($stmt, "i", $id_estudante);
	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);
	$row    = mysqli_fetch_array($result);

	if(!empty($row))
	{
		extract($row);

        $curso = ($codcurso == 13) ? 'Medicina' : '-';
	}

?>

    <div class="app-content content">
		<div class="content-wrapper container-xxl p-0">
            <div class="content-body">
          		<section class="app-user-view-account">
					<?php

						if($url == 1 )
						{
							include_once("{$raiz}php/perfil/agenda.php");
						} 
						elseif($url == 2 ) 
						{
							include_once("{$raiz}php/perfil/avaliacao.php");
						}
						else
						{
							include_once("{$raiz}php/perfil/dados.php");
						}

					?>
          		</section>
            </div>
        </div>
    </div>
    <?php

		include_once("{$raiz}template/footer.php");
		include_once("{$raiz}template/js/scripts.php");
		include_once("{$raiz}template/js/main.php");
		include_once("{$raiz}template/js/perfil.php");
		include_once("{$raiz}template/js/functions.php");
		include_once("{$raiz}template/js/assinatura.php");

		//Inclui modal de senha quando tiver reset senha no perfil
		if($_SESSION['reset'] == true)
		{
			include_once("{$raiz}modal/senha.php");

			echo "<script> $(window).on('load', function(){ $('#modal-senha').modal('show') }) </script>";
		}
	?>
    <script src="<?= $raiz ?>app-assets/vendors/js/file-uploaders/dropzone.js"></script>
	<script>
        <?php if(!empty($tipo) && !empty($id_problema) && !empty($id_avaliacao)){ ?>
/*
        $(document).ready(function() {
          
          var count = 0;
            
          function loadCardContent() {

              count++;

              console.log(count);

                $.ajax({
                    url: '../php/consulta/resposta_professor.php', // URL para sua página PHP que retorna o conteúdo
                    method: 'GET',
                    data: {
                        tipo: <?= $tipo ?>, // Substitua pelos valores reais dos parâmetros
                        id_problema: <?= $id_problema ?>,
                        id_avaliacao: <?= $id_avaliacao ?>
                    },
                    success: function(data) {
                        $('.card-body-content').html(data);
                    },
                    error: function(error) {
                        console.error('Erro ao carregar o conteúdo:', error);
                    }
                });
            }

            // Carrega o conteúdo inicialmente
            loadCardContent();

            // Atualiza o conteúdo a cada 10 segundos
            setInterval(loadCardContent, 10000);
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
*/
        <?php } ?>

        <?php if(empty($status_estudante)){ ?>
        $('#iniciar').on('click', function (e) {

			e.preventDefault()

			$.post( "<?= $raiz ?>php/form/inicia_avaliacao.php" ).done(function( data ) { 
                if(data)
                {
                    bootbox.confirm({
                        message: '<h5 class="text-center m-1">' + data + '</h5>',
                        closeButton: false,
                        centerVertical: true,
                        size: "small",
                        buttons: {
                            cancel: {
                                label: 'Cancelar',
                                className: 'd-none'
                            },
                            confirm: {
                                label: 'Continuar',
                                className: 'btn-primary'
                            }
                        },
                        callback: function (result) {
                            location.reload()
                             
                        }
                    })
                }
                else
                {
                    window.location.href = "perfil.php?url=2&p=1"
                }
            })
		})
        <?php } ?>

        <?php if(!empty($status_estudante) && $id_estudante == $_SESSION['id_estudante']){ ?>
        $('#atualiza').on('click', function (e) {
 
            var idProblema  = <?php echo $id_problema; ?>;
            var idAvaliacao = <?php echo $id_avaliacao; ?>;
            var status      = $(this).attr('data-id')

            bootbox.confirm({
                message: '<h5 class="text-center m-1">Você não poderá voltar.<br>Deseja prosseguir para o próximo passo?</h5>',
                closeButton: false,
                centerVertical: true,
                size: "small",
                buttons: {
                    cancel: {
                        label: 'Cancelar',
                        className: 'btn-secondary'
                    },
                    confirm: {
                        label: 'Confirmar',
                        className: 'btn-primary'
                    }
                },
                callback: function (result) {

                    if(result == true)
                    {
                        $.post( "<?= $raiz ?>php/form/atualiza_avaliacao.php", {
                            'status': status,
                             'id_problema': idProblema,
                             'id_avaliacao': idAvaliacao,
                       })
                        .done(function( data ) { 
                            if(data)
                            {
                                bootbox.confirm({
                                    message: '<h5 class="text-center m-1">' + data + '</h5>',
                                    closeButton: false,
                                    centerVertical: true,
                                    size: "small",
                                    buttons: {
                                        cancel: {
                                            label: 'Cancelar',
                                            className: 'd-none'
                                        },
                                        confirm: {
                                            label: 'Continuar',
                                            className: 'btn-primary'
                                        }
                                    },
                                    callback: function (result) {
                                        location.reload()
                                    }
                                })
                            }
                            else
                            {
                                window.location.href = "perfil.php?url=2&p=" + status
                            }
                        })                    
                    }
                }
            })

			e.preventDefault()

		})
        <?php } ?>

        <?php if(!empty($status_estudante) && $status_estudante == $tipo && $id_estudante == $_SESSION['id_estudante']){ ?>

        var idProblema  = <?php echo $id_problema; ?>;
        var idAvaliacao = <?php echo $id_avaliacao; ?>;
        var tipo        = <?php echo $tipo; ?>;

        $('#perguntas').on('click', function (e) {

            e.preventDefault();

            var selectedQuestions = $('input.question-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            $.post("<?= $raiz ?>php/form/escolhe_perguntas.php", {
                'checkbox[]': selectedQuestions,
                'id_problema': idProblema,
                'id_avaliacao': idAvaliacao,
                'tipo': tipo
            })
            .done(function(data) {
                if (data) {
                    alert(data);
                } else {
                    location.reload();
                }
            });
        });        
        <?php } ?>

        <?php if(!empty($status_estudante) && $status_estudante == $tipo && $id_estudante == $_SESSION['id_estudante']){ ?>

        $('#diagnostico').on('click', function (e) {

            var resposta = $('#resposta').val();

            e.preventDefault();

            $.post("<?= $raiz ?>php/form/diagnostico_avaliacao.php", {
                'resposta': resposta
            })
            .done(function(data) {
                if (data) {
                    bootbox.confirm({
                        message: '<h5 class="text-center m-1">' + data + '</h5>',
                        closeButton: false,
                        centerVertical: true,
                        size: "small",
                        buttons: {
                            cancel: {
                                label: 'Cancelar',
                                className: 'd-none'
                            },
                            confirm: {
                                label: 'Continuar',
                                className: 'btn-primary'
                            }
                        },
                        callback: function (result) {
                            location.reload()
                        }
                    })
                } else {
                    location.reload();
                }
            });
        });        
        <?php } ?>
        
        $(document).ready(function() {

            let currentMarker = null;

            // Inicializa tooltips do Bootstrap
            $('[data-toggle="tooltip"]').tooltip();

            // Mostrar informação no modal ao clicar na marcação
            $(document).on('click', '.marker-red', function() {
                $('#cabeca').modal('toggle');
            })

            $(document).on('click', '.marker', function() {

                var id = $(this).attr('data-id');

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '<?= $raiz ?>/php/consulta/pergunta.php',
                    async: true,
                    data: { id: id },
                    success: function(response) {

                        // Preenche inputs com dados
                        $.each(response, function(index, item) {
                            $("#" + index).html(item);
                        });

                        if (response['dir']) 
                        {
                            visualizarArquivo(response['dir']);

                            //abrir form de digitacao
                            $('#interpretar').removeClass('d-none')
                        }
                        else
                        {
                            $('#file-preview').html("<br>")
                            $('#interpretar').addClass('d-none')
                        }

                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: '<?= $raiz ?>php/form/escolhe_exame_fisico.php',
                            async: true,
                            data: { id: id },
                            success: function(response) {
                                if(parseInt(response))
                                {
                                    var id_pt = response

                                    $('#id_pergunta_turma').val(response)
                                }
                            }
                        });

                        $('#valor').val(money(response['valor']));

                        // Abre o modal
                        $('#new-task-modal').modal('toggle');

                    }
                });

                $('#id_pergunta').val(id);

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
                var fileURL = '../'+filePath;
                var fileName = fileURL.split('/').pop();
                var fileType = fileName.split('.').pop().toLowerCase();

                filePreview.empty(); 

                if (isImage(fileType)) {
                    var imgElement = $('<img>', {
                        src: fileURL,
                        class: 'img-fluid rounded-bottom w-100', /*
                        style: 'max-height: 400px; cursor: pointer;',
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#imageModal' */
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
            $('#new-task-modal').on('hidden.bs.modal', function () {
                $('#form-problema')[0].reset();
                $('#removeMarker').hide();
                currentMarker = null;
            });
        });

        var imageModalTriggered = false;

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
            var fileURL = '../'+filePath;
            var fileName = fileURL.split('/').pop();
            var fileType = fileName.split('.').pop().toLowerCase();

            filePreview.empty(); // Limpa o preview anterior

            if (isImage(fileType)) 
            {
                // Visualizar imagem
                var imgElement = $('<img>', {
                    src: fileURL,
                    class: 'img-fluid rounded-bottom w-100',
                    /*style: 'max-height: 400px; cursor: pointer;',
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#imageModal'*/
                });

                filePreview.append(imgElement);

                imgElement.on('click', function() {
                    $('#modalImage').attr('src', fileURL);
                });

            } 
            else if (isVideo(fileType)) 
            {
                // Visualizar vídeo
                filePreview.append('<video controls style="width:100%"><source src="' + fileURL + '" type="video/' + fileType + '"></video>');

            }
            else if (isAudio(fileType)) 
            {
                // Visualizar áudio
                filePreview.append('<audio controls style="width:100%"><source src="' + fileURL + '" type="audio/' + fileType + '"></audio>');

            } 
            else if (fileType === 'pdf') 
            {
                // Visualizar PDF
                filePreview.append('<embed src="' + fileURL + '" type="application/pdf" width="100%" height="400px" />');

            } 
            else
            {
                // Tipo de arquivo não suportado para visualização
                filePreview.append('<p>Arquivo selecionado não pode ser visualizado.</p>');
            }
        }
        
        $(document).ready(function() {
            // Captura o evento de clique em qualquer miniatura
            $('.thumbnail').on('click', function () {
                // Obtém o caminho da imagem da miniatura clicada
                var imgSrc = $(this).attr('src');

                // Define a imagem no modal
                $('#modalImage').attr('src', imgSrc);
            });
        });

	</script>
</body>
</html>