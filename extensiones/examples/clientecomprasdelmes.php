<?php


require_once "../../controladores/historialpagos.controlador.php";
require_once "../../modelo/historialpagos.modelo.php";




class  imprimirFactura{


public $id;

public function traerImpresionFactura(){


//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemVenta = "id";
$valorVenta = $this->id;

$respuestaVenta = ControladorHistorialpagos::ctrMostrarHistorialcompras($itemVenta, $valorVenta);



// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set margins
$pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setHeaderMargin(PDF_MARGIN_HEADER);
$pdf->setFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);
// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->setFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));








// Set some content to print
$bloque1 = <<<EOD



	<table>

		<tr>
			<td style="background-color:white; width:100%; text-align:center;font-weight: bold; font-size: 150%; color:green">REPORTE DE COMPRAS</td>
			<br>
			
		</tr><br>
		<tr>
			<td style="background-color:white;  width:30%">
				<div style="font-size:8.5px; text-align:center; line-height:15px;">	
					<br><img src="images/logoavicolajb.png">
				</div>
			</td>

			<td style="background-color:white;  width:20%">
				<div style="font-size:8.5px; text-align:center; line-height:15px;">			
					<br>
					Trujillo - La Libertad
					<br>
					Av. Buenos Aires # 363 Urb. Santa Isabel
				</div>
			</td>

			<td style="background-color:white; width:23%">
				<div style="font-size:8.5px; text-align:right; line-height:15px;">	
					<br>
					Teléfono: (044) 233249
					<br>
					administracion@avicolajb.com
				</div>	
			</td>

			<td style="background-color:white; width:27%; text-align:center; color:green">CODIGO.<br>$valorVenta</td>

		</tr>

	</table>





















EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $bloque1, 0, 1, 0, true, '', true);



// Set some content to print
$bloque2 = <<<EOD





	<table>
		
		<tr>
			
			<td style="width:540px"><img src="images/back.jpg"></td>
		
		</tr>

	</table>




EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $bloque2, 0, 1, 0, true, '', true);


$bloque3 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
		
		<td style="border: 1px solid #666; background-color:white; width:25%; text-align:center">CODIGO DE VENTA</td>
		<td style="border: 1px solid #666; background-color:white; width:25%; text-align:center">MONTO TOTAL</td>
		<td style="border: 1px solid #666; background-color:white; width:25%; text-align:center">COMPRA</td>
		<td style="border: 1px solid #666; background-color:white; width:25%; text-align:center">FECHA</td>

		</tr>

	</table>

EOF;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $bloque3, 0, 1, 0, true, '', true);

foreach ($respuestaVenta  as $key => $item) {

$bloque4 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
			
			



			<td style="border: 1px solid #666; color:#333; background-color:white; width:25%; text-align:center">
			$item[codigo]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:25%; text-align:center">
			S/.$item[total]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:25%; text-align:center">
			$item[estado]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:25%; text-align:center">
			$item[fecha]
			</td>


		</tr>

	</table>


EOF;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $bloque4, 0, 1, 0, true, '', true);
	
}




$bloque5 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">


	</table>

EOF;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $bloque5, 0, 1, 0, true, '', true);







$pdf->Output('factura.pdf', 'I');


		}





}


$factura = new imprimirFactura();
$factura -> id = $_GET["id"];
$factura -> traerImpresionFactura();