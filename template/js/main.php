<script>

    document.addEventListener('DOMContentLoaded', function() {
        flatpickr('.data', {
            locale: "pt",
            dateFormat: 'd/m/Y',
            allowInput: true,
            disableMobile: true
        });
    });

	$(".detalhe").click(function(){

		if ($(".detalhe").hasClass("btn-flat-light"))
		{
			mostra()
		}
		else
		{
			oculta()
		}
	})

	$(window).on('load', function(){

		if (feather) 
		{
			feather.replace({
				width: 14,
				height: 14
			});
		}

		//Cria mascara para campos de telefone, cpf e data
		$(".tel").mask("(99)99999-9999")
		$(".cpf").mask("999.999.999-99")
		$(".cnpj").mask("99.999.999/9999-99")
		$(".data").mask("99/99/9999")
		$(".agenda").mask("99/99/9999 99:99")
		$(".nasc").mask("99/9999")
		$('.valor').mask("999.999,99", {reverse: true})

        $('[data-bs-toggle="tooltip"]').tooltip();

		//Pega o nome da pagina
		var url = location.pathname.substring(location.pathname.lastIndexOf("/") + 1)

		jQuery(function ($) {        
		  $('form').bind('submit', function () {
			$(this).find(':select').prop('disabled', false);
		  });
		});

		$('form').on('submit', function (e) {
 
			e.preventDefault();

			// Remover qualquer destaque de campos anteriores
			$(this).find(':input[required]').removeClass('border-danger');

			// Verificar campos obrigatórios não preenchidos
			var camposInvalidos = $(this).find(':input[required]').filter(function () {
				return !$(this).val();
			});

			// Verificar campos de seleção que precisam ter algo selecionado
			$(this).find('select[required]').each(function () {

				if ($(this).val() == '0') 
                {

					$(this).addClass('border-danger');

					camposInvalidos.push($(this));
				}
			});

			// Se houver campos obrigatórios não preenchidos, destacá-los e interromper o envio
			if (camposInvalidos.length > 0) 
            {
				camposInvalidos.addClass('border-danger');

				alert("Por favor, preencha todos os campos obrigatórios.");

				return;
			}

			let dialog = bootbox.dialog({
				message: '<p class="text-center mb-0"><i class="fas fa-spin fa-cog"></i>&nbsp;  Por favor, espere enquanto cadastramos...</p>',
				closeButton: false
			});

			var btn = $('button[type=submit]');
			var txt = btn.val();

			btn.prop('disabled', true);
			btn.val("Enviando...");

			//var form   = $(this);
			//var dados  = form.serialize();
            
            var form   = $(this)[0];
            var dados  = new FormData(form);
            
			//var url    = form.attr('action');
			//var method = form.attr('method');

			$.ajax({
                type: form.method,
                url: form.action,
                data: dados,
                contentType: false,
                processData: false,
                success: function(response) {

					dialog.modal('hide');

                    bootbox.hideAll();

                    btn.prop('disabled', false);
                    btn.val(txt);
                    
                    var idform = $(form).attr('id');

                    if(url == 'problema.php')
                    {
                        var paramP = getParameterByName('p');

                        console.log(url + "?id=" + response + "&p=" + paramP)
                        window.location.href = (url + "?id=" + response + "&p=" + paramP)
                    }
                    else if (idform === 'form-problema')
                    {
                        var id     = getParameterByName('id');
                        var pro    = getParameterByName('pro');
                        var paramP = getParameterByName('p');

                        console.log(url + "?id=" + id + "&pro=" + pro + "&p=" + paramP)
                        window.location.href = (url + "?id=" + id + "&pro=" + pro + "&p=" + paramP)
                    }
                    else
                    {
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }

				}
            }).fail(function (jqXHR, textStatus, errorThrown) {
                dialog.modal('hide');
                btn.prop('disabled', false);
                btn.val(txt);
                console.error("Erro na requisição AJAX:", errorThrown);
                alert("Ocorreu um erro durante o envio do formulário. Por favor, tente novamente.");
            });

		});

		$('#estilo').on('click', function (e) {

			e.preventDefault()

			$.post( "<?= $raiz ?>php/edita/estilo.php" ).done(function( data ) { location.reload() })

		})

		$('#menu').on('click', function (e) {

			e.preventDefault()

			$.post( "<?= $raiz ?>php/edita/menu.php" ).done(function( data ) { } )

		})
	})

	//Mostra modal de confirmação de deleção
	$(document).on('click', '.deletar', function(event){

		var title = $(this).attr('data-title')
		var id    = $(this).attr('data-id')
		var name  = $(this).attr('data-name')

		bootbox.confirm({
			message: '<h5 class="text-center m-1">Deseja deletar ' + title + '?</h5>',
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
					// Chama sua função para deletar os dados
					deletar(id, name)
				}

			}
		})

		return false
	})


</script>