<script>

	function mostra()
	{
		$(".detalhe").removeClass("btn-flat-light")
		$(".detalhe").addClass("btn-flat-secondary active")

		$(".detalhe").html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg> <span>Detalhes</span>')

		$('.formCheck').addClass('d-flex')
		$('.formCheck').removeClass('d-none')

		$('.formInput').addClass('d-block')
		$('.formInput').removeClass('d-none')
	}

	function oculta()
	{
		$(".detalhe").removeClass("btn-flat-secondary active")
		$(".detalhe").addClass("btn-flat-light")

		$(".detalhe").html('<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg> <span>Detalhes</span>')

		$('.formCheck').addClass('d-none')
		$('.formCheck').removeClass('d-flex')

		$('.formInput').addClass('d-none')
		$('.formInput').removeClass('d-block')
	}

	function money(num)
	{
		num = parseFloat(num).toFixed(2)
		num = num.replace(".", ",")
		num = num.replace("-", "")
		return num
	}

	function dateNow()
	{ 
		var today = new Date()
		var dd    = today.getDate()
		var mm    = today.getMonth() + 1

		var yyyy = today.getFullYear()

		if (dd < 10)
		{
		  dd = '0' + dd
		}

		if (mm < 10)
		{
		  mm = '0' + mm
		} 

		return dd + '/' + mm + '/' + yyyy
	}

	//Função que faz a deleção do item clicado
	function deletar(id, name)
	{
		$.ajax({
			type: 'POST',
			url: 'php/delete/delete.php',
			data: {
					id 	 : id,
					name : name
				  },
            success: function(response) {
                location.reload();
            }
		})
		.fail(function(jqXHR, textStatus, msg){
			 alert(msg)
		})
	}

    function getParameterByName(name) 
    {
        name = name.replace(/[\[\]]/g, "\\$&");

        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(window.location.href);

        if (!results) return null;

        if (!results[2]) return '';

        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

	function resetModal(modal, form, title, elements = []) 
	{
		$(modal).on('hidden.bs.modal', function () 
		{
			$(form)[0].reset();

			$(elements.join(',')).val("");

			$('.modal-title').html(title);
			$('.btn-cadastrar').html("Cadastrar");

		})
	}

    function linkNotificacao(id, link)
    {
        $.ajax({
            type: 'POST',
            url: 'php/edita/notificacao_professor.php',
            data: { id : id },
            success: function(response) {
                window.location.href = link
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            alert("Ocorreu um erro durante o envio do formulário. Por favor, tente novamente.");
        });
    }

</script>