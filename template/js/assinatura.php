<script src="app-assets/vendors/js/file-uploaders/dropzone.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>

	//Mostra modal de confirmação de deleção
	$(document).on('click', '.deleta-img', function(event){

		var title = $(this).attr('data-title')
		var id    = $(this).attr('data-id')
		var name  = $(this).attr('data-name')
		var dir   = $(this).attr('id')

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
					removeImg(id, name, dir)
				}

			}
		})

		return false
	})

	function removeImg(id, name, dir)
	{

		$.ajax({
			type : 'POST',
			url  : '<?= $raiz ?>php/delete/deletar-img.php',
			data : { 
					id   : id, 
					name : name, 
					dir  : dir 
				   },
			success: function(response)
			{
				bootbox.alert({
                    message: '<h5 class="text-center mt-2 mb-2 m-1">' + response + '</h5>',
                    closeButton: false,
                    centerVertical: true,
                    size: "small",
                }).on('hidden.bs.modal', function() {
                    location.reload();
                });
			}
		})

	}

</script>