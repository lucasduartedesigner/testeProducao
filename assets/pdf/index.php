<?php

	include("mpdf60/mpdf.php");

	$mpdf = new mPDF(
             '',   // mode - default ''
             '',   // format - A4, for example, default ''
             12,   // font size - default 0
             '',   // default font family
             15,   // margin_left
             15,   // margin right
             88,   // margin top    -- aumentei aqui para que não ficasse em cima do header
             50,   // margin bottom
             8,    // margin header
             5,    // margin footer
             'L');

	$mpdf->SetTitle('Resultado Exame');

	$nome_vet   = "Rodrigo Cruz";
	$crmv_vet   = "CRMV RJ 6238";
	$assinatura = "https://www.labpetdiagnostico.com/app/app-assets/images/assinatura/assinatura-9.png";

	$header		= "<div>
					<div style='margin-bottom:20px'>
						<b>Exame Laboratorial nº152940<b>
					</div>
					<div style='width:25%;float:left'>
						Paciente: Sushi
					</div>
					<div style='width:25%;float:left'>
						Espécie: Canina
					</div>
					<div style='width:25%;float:left'>
						Sexo: Macho
					</div>
					<div style='width:25%;float:left'>
						Idade: 8 anos
					</div>
					<div style='margin-top:10px'>
						Proprietário: Rodrigo / Fernanda
					</div>
					<div style='margin-top:10px'>
						Clínica: Lab&Pet diagnóstico veterinário
					</div>
					<div style='margin-top:10px'>
						Veterinário: Rodrigo Cruz
					</div>

				  </div>";

	$body		= "<div>
					Bioquimica
				  </div>";

	$mpdf->SetHTMLHeader("<table style='position:absolute; width:100%;margin-bottom:20px'>
							<tr>
								<td width='50%' align='left'>
									<img src='https://www.labpetdiagnostico.com/app/app-assets/images/labpet.png' style='width:230px'> 
								</td>
								<td width='50%' align='right'>
									<h4>Data 12/01/2023</h4>
								</td>
							</tr>
						  </table>
						  $header");

	$mpdf->SetHTMLFooter("<table style='
							position:absolute;
							width:100%;
							margin-top:-34px;
							border: 0px
							'>
							<tr>
								<td width='33%'>
									Responsável técnico
									<br>
									Rodrigo Cruz
									<br>
									CRMV RJ 6238
								</td>
								<td width='33%' align='center'>
									<img src='$assinatura' style='width:150px'>
									<br><br>
									$nome_vet
									<br>
									$crmv_vet
								</td>
								<td width='33%' style='text-align: right;'>
									<img src='https://qrcg-free-editor.qr-code-generator.com/main/assets/images/websiteQRCode_noFrame.png'  style='width:150px'>
								</td>
							</tr>
						  </table>");

	//$mpdf->SetMargins(15, 10, 15);

	$mpdf->WriteHTML($body);

	$mpdf->Output('saidaPDF.pdf', 'I');

	exit;

?>