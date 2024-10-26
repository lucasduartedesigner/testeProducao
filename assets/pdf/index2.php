<?php 

 include("mpdf60/mpdf.php");

 $html = "<body>
				 <h1 style='padding-top:100px'>Comprovante de Recibo</h1>
				 <p class='center sub-titulo'>
				 Nº <strong>0001</strong> - 
				 VALOR <strong>R$ 700,00</strong>
				 </p>
				 <p>Recebi(emos) de <strong>Ebrahim Paula Leite</strong></p>
				 <p>a quantia de <strong>Setecentos Reais</strong></p>
				 <p>Correspondente a <strong>Serviços prestados ..<strong></p>
				 <p>e para clareza firmo(amos) o presente.</p>
				 <p class='direita'>Itapeva, 11 de Julho de 2017</p>

				 <p>Assinatura </p>

				 <p>Nome <strong>Alberto Nascimento Junior</strong> CPF/CNPJ: <strong>222.222.222-02</strong></p>
				 <p>Endereço <strong>Rua Doutor Pinheiro, 144 - Centro, Itapeva - São Paulo</strong></p>

				 <div class='creditos'>
				 	<p>teste</p>
				 </div>
			</body>";

 //$mpdf = new mPDF('','LETTER-L','','',35,35,60,25,10,10);

 $mpdf = new mPDF();

 $mpdf->SetTitle('My Title');

 $mpdf->SetDisplayMode('fullpage');

 $css = file_get_contents("css/estilo.css");

$logo = "<img src='https://www.labpetdiagnostico.com/app/app-assets/images/labpet.png' style='width:180px'>";

$data = "<div style='margin-top:-40px'>Data 10/01/2023</div>";

$responsavel = "<div><br><br>Responsável Tecnico:<br> Rodrigo Cruz <br> CRMV RJ 6238 </div>";

$footerContent = "<img src='https://www.labpetdiagnostico.com/app/app-assets/images/assinatura/assinatura-9.png' style='width:120px;margin-top:40px'><br>Nome do Veterinario";

$qrcode = "<img src='https://qrcg-free-editor.qr-code-generator.com/main/assets/images/websiteQRCode_noFrame.png'  style='width:120px;margin-bottom:10px'>";

$header =[
			'L' 	=> [ 'content' => $logo ],
			'C' 	=> [ 'content' => '' ],
			'R' 	=> [ 'content' => $data ],
			'line' 	=> 0, 
  		 ];

$footer = [
			'L' 	=> [ 'content' => $responsavel ],
			'C' 	=> [ 'content' => $footerContent ],
			'R' 	=> [ 'content' => $qrcode ],
			'line'  => 0,
  		  ];


$footerConfiguration = [
  'odd'  => $footer
];

$headerConfiguration = [
  'odd'  => $header
];

$mpdf->SetHeader($headerConfiguration);
$mpdf->SetFooter($footerConfiguration);

$mpdf->WriteHTML($css,1);

$mpdf->WriteHTML($html);

$mpdf->AddPage();

$mpdf->WriteHTML($html);

$mpdf->Output('teste.pdf', "I");

exit;