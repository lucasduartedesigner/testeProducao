<?php

	function dateDB($x)
	{
		if(!empty($x))
		{
			return '"' . date('Y-d-m', strtotime("01/".$x)) . '"';
		}
		else
		{
			return "null";
		}
	}

	function data($x)
	{
		if(!empty($x))
		{
			$date = DateTime::createFromFormat('d/m/Y', $x);
			$date = $date->format('Y-m-d');

			return "'$date'";
		}
		else
		{
			return "null";
		}
	}

    function dataBR($x)
    {
        if(!empty($x))
        {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $x);

            if ($date) 
            {
                $date = $date->format('d/m/Y');

                return $date;
            }
        }
    }

	function databind($x)
	{
		if(!empty($x))
		{
			$date = DateTime::createFromFormat('d/m/Y', $x);
			$date = $date->format('Y-m-d');

			return $date;
		}
		else
		{
			return "null";
		}
	}

	function datatimebind($x)
	{
		if(!empty($x))
		{
			$date = DateTime::createFromFormat('d/m/Y H:i', $x);
			$date = $date->format('Y-m-d H:i');

			return $date;
		}
		else
		{
			return "null";
		}
	}

	function datetimeDB($x)
	{
		if(!empty($x))
		{
			$date = DateTime::createFromFormat('d/m/Y H:i', $x);
			$date = $date->format('Y-m-d H:i');

			return "'$date'";
		}
		else
		{
			return "null";
		}
	}

	function intDB($x)
	{
		if(!empty($x))
		{
			return $x;
		}
		else
		{
			return "null";
		}
	}

	function stringDB($x)
	{
		if(!empty($x))
		{
			return $x;
		}
		else
		{
			return "";
		}
	}

	function floatDB($x)
	{
		if(!empty($x))
		{
			return str_replace(",", ".", str_replace(".", "", $x));
		}
		else
		{
			return "null";
		}
	}

	function floatView($x)
	{
		if(!empty($x))
		{
			return number_format($x, 2, '.', ',');
		}
		else
		{
			return "";
		}
	}

	function valor($x)
	{
		if(!empty($x))
		{
			return number_format($x, 2, ',', '.');
		}
		else
		{
			return "";
		}
	}

	function moeda($x)
	{
		if(!empty($x))
		{
			return "R$ " . number_format($x, 2, ',', '.');
		}
		else
		{
			return "";
		}
	}

	function porcentagem($x, $y)
	{
		if($y > 0)
		{
			return ( $x * 100 ) / $y;
		}
	}

	function somenteNumero($x)
	{
		return preg_replace("/[^0-9]/", "", $x);
	}

	function itemMenu($id, $nome, $link, $ico, $class, $sub_menu = null)
	{
		return "<li class='nav-item $class'>
				<a class='d-flex align-items-center menu' href='$link' data-title='$nome' data-menu='$id'>
					$ico
					<span class='menu-item text-truncate' data-i18n='$nome'>$nome</span>
				</a>
				$sub_menu
			  </li>";
	}

	function colunaEstatistica($title, $valor, $icone, $color)
	{
	  echo "<div class='col-xxl-3 col-xl-3 col-lg-3 col-sm-6 col-12 mt-1 mb-xl-0'>";
			echo "<div class='d-flex flex-row'>";
				echo "<div class='avatar $color me-2'>";
					echo "<div class='avatar-content'>";
						echo "<i data-feather='$icone' class='avatar-icon'></i>";
					echo "</div>";
				echo "</div>";
				echo "<div class='my-auto'>";
					echo "<h4 class='fw-bolder mb-0'>$valor</h4>";
					echo "<p class='card-text font-small-3 mb-0'>$title</p>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	}

	function tabelaExames($nome, $categoria, $qtd, $valor)
	{
		 echo "<tr>";
			echo "<td>";
				echo $nome;
			echo "</td>";
			echo "<td>";
				echo $categoria;
			echo "</td>";
			echo "<td>";
				echo $qtd;
			echo "</td>";
			echo "<td>";
				echo $valor;
			echo "</td>";
		echo "</tr>";
	}

	function inputForm($cols, $label, $name, $value = null, $config = null, $class = null, $type = null)
	{
		$type = (isset($type)) ? $type : 'text';

		echo "<div class='$cols mb-1'>";
			echo "<label class='form-label'>$label</label>";
			echo "<input type='$type' class='form-control $class' id='$name' name='$name' value='$value' $config/>";
		echo "</div>";
	}

	function inputHidden($name, $value = null)
	{
		echo "<input type='hidden' id='$name' name='$name' value='$value'/>";
	}

	function textarea($cols, $label, $name, $value = null, $rows = null, $config = null)
	{
		echo "<div class='$cols mb-1'>";
			echo "<label class='form-label'>$label</label>";
			echo "<textarea class='form-control' id='$name' name='$name' rows='$rows' $config>$value</textarea>";
		echo "</div>";
	}

	function selectOptions($cols, $label, $name, $value, $options, $readonly = null)
	{
		echo "<div class='$cols mb-1'>";
		  echo "<label class='form-label'>$label</label>";
		  echo "<select class='form-control form-select' id='$name' name='$name' $readonly>";

				foreach( $options as $key => $name ){

					$number = $key + 1;

					if($number == $value){ $selected = "selected"; }else{ $selected = ""; }

					echo "<option value='$number' $selected >$name</option>";
				}

		  echo "</select>";
		echo "</div>";

	}

	function selectOptionsKey($cols, $label, $name, $value, $options, $readonly = null)
	{
		echo "<div class='$cols mb-1'>";
		  echo "<label>$label</label>";
		  echo "<select class='form-control form-select' id='$name' name='$name' $readonly>";

				foreach( $options as $key => $name ){

					if($key == $value){ $selected = "selected"; }else{ $selected = ""; }

					echo "<option value='$key' $selected >$name</option>";
				}

		  echo "</select>";
		echo "</div>";

	}

	function inputswitch($cols, $label, $name, $value = null, $checked = null)
	{
		echo "<div class='$cols mb-1'>
				<label class='form-check-label' for='$name'>$label</label>
				<div class='form-check form-switch'>
					<input type='checkbox' name='$name' class='form-check-input' id='$name' value='$value' $checked>
				</div>
			  </div>";
	}

	function msgNotExists($title, $msg, $link = null, $raiz = null)
	{
		echo "<section id='faq-tabs'>";
			echo "<div class='card pt-2 pb-2'>";
				echo "<div class='row justify-content-center'>";
					echo "<div class='col-lg-4 col-md-4 col-sm-12'>";
						echo "<img src='{$raiz}app-assets/images/illustration/email.svg' class='card-img-top' alt='knowledge-base-image'>";
						echo "<div class='card-body text-center'>";
							echo "<h3>$title</h3>";
							echo "<p class='blockquote mt-2 mb-2'>$msg</p>";

							if(!empty($link))
							{
								echo "<a class='btn btn-outline-primary ps-5 pe-5' $link>Adicionar</a>";
							}

						echo "</div>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</section>";
	}

	function btnEdit($href)
	{
		echo "<a class='btn btn-icon btn-primary waves-effect waves-float waves-light' $href >";
			echo "<svg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-edit'><path d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7'></path><path d='M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'></path></svg>";
		echo "</a>";
	}

	function btnDelete($dataId, $dataTitle, $dataName)
	{
		echo "<button class='btn btn-icon btn-danger waves-effect waves-float waves-light deletar' data-id='$dataId' data-title='$dataTitle' data-name='$dataName'>";
			echo "<svg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-trash-2'><polyline points='3 6 5 6 21 6'></polyline><path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path><line x1='10' y1='11' x2='10' y2='17'></line><line x1='14' y1='11' x2='14' y2='17'></line></svg>";
		echo "</button>";
	}

	function hourForMin($hour)
	{
		 $part = explode(":", $hour);

		 $min  = ($part[0]*60) + $part[1];

		 return $min;
	}

	function dataRange()
	{
		$hoje 		= date('Y-m-d');
		$inicioMes 	= date('01-m-Y', strtotime($hoje));
		$fimMes 	= date('t-m-Y', strtotime($hoje));

		$inicioMesFormatado = date('d/m/Y', strtotime($inicioMes));
		$fimMesFormatado 	= date('d/m/Y', strtotime($fimMes));

		return array('inicio' => $inicioMesFormatado, 'fim' => $fimMesFormatado);
	}

	function dataRange1()
	{
		$hoje 		= date('Y-m-d');
		$inicioMes 	= date('01-m-Y', strtotime($hoje));
		$fimMes 	= date('t-m-Y', strtotime($hoje));

		$inicioMesFormatado = date('d/m/Y', strtotime($hoje));
		$fimMesFormatado 	= date('d/m/Y', strtotime($hoje));

		return array('inicio' => $inicioMesFormatado, 'fim' => $fimMesFormatado);
	}

	function gerarTokenSeguro($tamanho = 128) 
	{
		$bytes = openssl_random_pseudo_bytes($tamanho);
		$token = bin2hex($bytes);

		return $token;
	}

	function mesExtenso($date = 'today') 
	{
		$today 	 = new DateTime($date);
		$nomeMes = $today->format('F');

		$traducaoMes = array(
			'January' => 'Janeiro',
			'February' => 'Fevereiro',
			'March' => 'Março',
			'April' => 'Abril',
			'May' => 'Maio',
			'June' => 'Junho',
			'July' => 'Julho',
			'August' => 'Agosto',
			'September' => 'Setembro',
			'October' => 'Outubro',
			'November' => 'Novembro',
			'December' => 'Dezembro'
		);

		return $traducaoMes[$nomeMes];
	}

    function removeNullFromArray($array)
    {
        return array_filter($array, function ($value) {
            return $value !== null && $value !== '';
        });
    }

    function formatarCPF($cpf) 
    {
        // Remove qualquer caractere que não seja número
        $cpf = preg_replace('/\D/', '', $cpf);

        // Verifica se o CPF tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Formata o CPF com pontos e traço
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '\1.\2.\3-\4', $cpf);
    }

    function statusCaso($status)
    {
        switch ($status) 
        {
            case 1:
                return "Agendado";
            case 2:
                return "Em andamento";
            case 3:
                return "Concluído";
            case 4:
                return "Cancelado";
            default:
                return "Agendado";
        }
    }


?>