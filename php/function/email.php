<?php 

function modeloEmail($title, $nome, $header, $body, $main, $btn_link, $btn_txt, $rodape, $system_link, $logo, $laboratorio, $width = null)
{

	$width = (!empty($width)) ? $width : 600;
    
    $data = date('Y');

	$html = "
	<!DOCTYPE html>
	<html lang='pt-br'>
	  <head>
	  	<meta charset=”UTF-8″>
		<style>
		  .hover-underline:hover {
			text-decoration: underline !important;
		  }
		  td{
			text-align: -webkit-center;
			background-color: rgb(255, 255, 255);
		  }
		  @keyframes spin {
			to {
			  transform: rotate(360deg);
			}
		  }

		  @keyframes ping {

			75%,
			100% {
			  transform: scale(2);
			  opacity: 0;
			}
		  }

		  @keyframes pulse {
			50% {
			  opacity: .5;
			}
		  }

		  @keyframes bounce {

			0%,
			100% {
			  transform: translateY(-25%);
			  animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
			}

			50% {
			  transform: none;
			  animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
			}
		  }

		  @media (max-width: {$width}px) {
			.sm-leading-32 {
			  line-height: 32px !important;
			}

			.sm-px-24 {
			  padding-left: 24px !important;
			  padding-right: 24px !important;
			}

			.sm-py-32 {
			  padding-top: 32px !important;
			  padding-bottom: 32px !important;
			}

			.sm-w-full {
			  width: 100% !important;
			}
		  }
		</style>
	  </head>

	  <body style='
				  margin: 0; 
				  padding: 0; 
				  width: 100%; 
				  word-break: break-word; 
				  -webkit-font-smoothing: antialiased; 
				  --bg-opacity: 1; 
				  background: #ECEFF1 
				  background-color: rgba(236, 239, 241, var(--bg-opacity));
	  '>

		<div style='display: none;'>$title</div>

		<div role='article' aria-roledescription='email' aria-label='$title' lang='pt-br'>

		  <table style='background: #ECEFF1;
						font-family: Montserrat, -apple-system, \"Segoe UI\", sans-serif; 
		  width: 100%;' width='100%' cellpadding='0' cellspacing='0' role='presentation'>

			<tr>
			  <td align='center' style='
										  --bg-opacity: 1; 
										  background-color: #eceff1; 
										  background-color: rgba(236, 239, 241, var(--bg-opacity)); 
										  font-family: Montserrat, -apple-system, \"Segoe UI\", sans-serif;' 
			  bgcolor='rgba(236, 239, 241, var(--bg-opacity))'>

				<table class='sm-w-full' style='font-family: \"Montserrat\",Arial,sans-serif; width: {$width}px;' width='{$width}' cellpadding='0' cellspacing='0' role='presentation'>

				  <tr>
					<td class='sm-py-32 sm-px-24' style='
															font-family: Montserrat, -apple-system, \"Segoe UI\", sans-serif; 
															padding: 24px; 
															text-align: center;
															background: #ECEFF1' align='center'>

					  <a href='$system_link'>
						<img src='$logo' width='220' style='
						border: 0; 
						max-width: 100%; 
						line-height: 100%; 
						vertical-align: middle;'>
					  </a>

					</td>
				  </tr>

				  <tr>
					<td align='center' class='sm-px-24' style='font-family: \"Montserrat\",Arial,sans-serif;'>

					  <table style='
					  font-family: \"Montserrat\",Arial,sans-serif; 
					  width: 100%;'
					  width='100%' cellpadding='0' cellspacing='0' role='presentation'>

						<tr>
						  <td class='sm-px-24' style='
						  --bg-opacity: 1; 
						  background-color: #ffffff; 
						  background-color: rgba(255, 255, 255, var(--bg-opacity)); 
						  border-radius: 4px; 
						  font-family: Montserrat, -apple-system, \"Segoe UI\", sans-serif; 
						  font-size: 14px; 
						  line-height: 24px; 
						  padding: 48px; 
						  text-align: left; 
						  --text-opacity: 1; 
						  color: #626262; 
						  color: rgba(98, 98, 98, var(--text-opacity));'
						  bgcolor='rgba(255, 255, 255, var(--bg-opacity))' align='left'>
	"; 

		if(!empty($nome)){
			$html .="
			<p style='font-weight: 600; font-size: 18px; margin-bottom: 0;'>Oi</p>
			<p style='font-weight: 700; font-size: 20px; margin-top: 0; --text-opacity: 1; color: #ff5850; color: rgba(13, 137, 158, var(--text-opacity));'>$nome!</p>
			";
		}

		if(!empty($header)){
			$html .="
			<p class='sm-leading-32' style='font-weight: 600; font-size: 20px; margin: 0 0 16px; --text-opacity: 1; color: #263238; color: rgba(38, 50, 56, var(--text-opacity));'>
				$header
			</p>
			";
		}

		if(!empty($body)){
			$html .="<p style='margin: 0 0 24px;'>
				$body 
			</p>";
		}

		if(!empty($main)){ 
			$html .="<p style='margin: 0 0 24px;'>
				 $main 
			</p>";
		} 

		if(!empty($btn_link) && !empty($btn_txt)){ 
			$html .="<a href='$btn_link' style='background-color:#0D899E;border:1px solid #0D899E;border-color:#0D899E;border-width:1px;color:#ffffff;display:inline-block;font-size:14px;font-weight:bold;padding:16px 24px 16px 24px;text-align:center;text-decoration:none;border-style:solid;font-family: Montserrat, -apple-system, \"Segoe UI\", sans-serif;' target='_blank' data-saferedirecturl='$btn_link'>$btn_txt </a>";
		}
		if(!empty($rodape)){ 
			$html .="
						<div style='--bg-opacity: 1; 
						background-color: #eceff1; 
						background-color: rgba(13, 137, 158, var(--bg-opacity)); 
						height: 1px; 
						line-height: 1px;
						margin: 20px 0'>&zwnj;</div>
						<p style='margin: 0 0 16px;'>
						   $rodape 
						</p>
					";
		} 
		if(!empty($laboratorio)){ 
			$html .="<p style='margin: 0 0 16px;'>Obrigado, <br> $laboratorio </p>";
		} 

	$html .="
						  </td>
						</tr>
						<tr>
						  <td style='background: #ECEFF1' height='20'></td>
						</tr>
						<tr style='background: #ECEFF1'>
						  <td style='
						  font-family: Montserrat, -apple-system, \"Segoe UI\", sans-serif; 
						  font-size: 12px; 
						  padding-left: 48px; 
						  padding-right: 48px; 
						  --text-opacity: 1; 
						  color: #eceff1; 
						  color: rgba(236, 239, 241, 
						  var(--text-opacity));background: #ECEFF1'>
							<p align='center' style='
							--text-opacity: 1; 
							color: #263238; 
							color: rgba(13, 137, 158, var(--text-opacity));'>
								Copyright &copy; $data
								<a class='ms-25' href='$system_link' target='_blank'>$laboratorio</a>,
								<span class='d-none d-sm-inline-block'> Todos os direitos reservados</span>
							</p>
						  </td>
						</tr>
						<tr>
						  <td style='background: #ECEFF1' height='16'></td>
						</tr>
					  </table>
					</td>
				  </tr>
				</table>
			  </td>
			</tr>
		  </table>
		</div>
	  </body>
	</html>
	";

	return $html;

}
?>