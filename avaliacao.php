<?php include('template/config.php'); ?>
<!DOCTYPE html>
<html class="loading" lang="pt-br">
<?php 

	$title = "Avaliação";

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
            include_once('lista/avaliacao.php');
            include_once('modal/avaliacao.php'); 
		?>
    </div>

    <?php 
		include('template/footer.php'); 
		include('template/js.php'); 
		include('template/js/functions.php');
	?>

	<script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/date-eu.js"></script>
	<script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/datetime-moment.js"></script>

	<script>

        function editar(id) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'php/consulta/avaliacao.php',
                async: true,
                data: { id: id },
                success: function(response) {

                    $.each(response, function(index, item) {

                        if (index === 'subturmas') 
                        {
                            var subturmasArray = item.split(',');

                            $('#subturma').val(subturmasArray).trigger('change');
                        } 
                        else
                        {
                            $("#" + index).val(item);
                        }

                    });

                    $('.modal-title').html("Alterar Avaliação");
                    $('.btn-cadastrar').html("Alterar");

                    $('#modal-form').modal('toggle');
                }
            });
        }
        
        $('#modal-form').on('hidden.bs.modal', function () {
            $('#form-avaliacao')[0].reset();
            $('#id_avaliacao').val("");
            
            $('#subturma').val(null).trigger('change');

            $('.modal-title').html("Adicionar Avaliação");
            $('.btn-cadastrar').html("Cadastrar");
        })

        $(document).ready(function () {	

            jQuery.extend(jQuery.fn.dataTableExt.oSort, {

                "date-br-pre": function (a) {

                    if (a == null || a === "") 
                    {
                        return 0;
                    }

                    // Verifica se a string contém a barra '/' esperada
                    if (typeof a !== 'string' || !a.includes('/'))
                    {
                        return 0;
                    }

                    var brDatea = a.split('/');

                    if (brDatea.length < 3) 
                    {
                        return 0;
                    }

                    return (brDatea[2] + brDatea[1] + brDatea[0]) * 1;
                },

                "date-br-asc": function (a, b) {
                    return a - b;
                },

                "date-br-desc": function (a, b) {
                    return b - a;
                }
            });

            $('.table-avaliacao thead tr').clone(true).addClass('filters').appendTo('.table-avaliacao thead');

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

                        if (i === 0 || i === 7)
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
                                    this.value !== ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value !== '',
                                    this.value === ''
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
                "order": [[ 4, "desc" ]],
                "pageLength": 50,
                columnDefs: [
                    { orderable: false, targets: [0, 7] },
                    { type: 'num', targets: 2 },
                    { type: 'date-br', targets: [4, 5] }
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