<?php

error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
if (ob_get_level()) ob_end_clean();

require_once "../../controladores/pagos.controlador.php";
require_once "../../modelo/pagos.modelo.php";




class  imprimirFactura{


public $id;

public function traerImpresionFactura(){


//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemVenta = "id";
$valorVenta = $this->id;

$respuestaVenta = ControladorPagos::ctrMostrarHistorialpagosreporte($itemVenta, $valorVenta);
$respuestaVenta2 = ControladorPagos::ctrMostrarHistorialpagosreporte2($itemVenta, $valorVenta);


$cliente2 = ($respuestaVenta2["cliente"]);
$dni2 = ($respuestaVenta2["dni"]);
$idcliente2 = ($respuestaVenta2["idcliente"]);
$nombrecajero = ($respuestaVenta2["nombrecajero"]);




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
			<td style="background-color:white; width:70%; text-align:center;font-weight: bold; font-size: 100%; color:green">REPORTE GENERAL DE PAGOS</td>
						<td style="background-color:white; width:27%; text-align:center; color:green">CODIGO: $valorVenta</td>

		</tr><br>
	

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

	<table style="font-size:9px;  padding:2px 1px;">
	
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:50% ">

				CLIENTE: $cliente2 

			</td>

			<td style="border: 1px solid #666; background-color:white; width:50%; text-align:center">
			
				DNI: $dni2

			</td>

			</tr>	
	</table>

<br>


EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $bloque2, 0, 1, 0, true, '', true);


$bloque3 = <<<EOF

	<table style="font-size:9px;  padding:2px 1px;">

		<tr>
		
		<td style="border: 1px solid #666; background-color:white; width:16%; text-align:center">S/PAGO</td>
		<td style="border: 1px solid #666; background-color:white; width:45%; text-align:center">DETALLE</td>
		<td style="border: 1px solid #666; background-color:white; width:20%; text-align:center">FECHA</td>
		<td style="border: 1px solid #666; background-color:white; width:19%; text-align:center">CAJA</td>

		</tr>

	</table>

EOF;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $bloque3, 0, 1, 0, true, '', true);

foreach ($respuestaVenta  as $key => $item) {

$bloque4 = <<<EOF

	<table style="font-size:9px;  padding:2px 1px;">

		<tr>
			
			



			<td style="border: 1px solid #666; color:#333; background-color:white; width:16%; text-align:center">
			$item[cantidad]
			</td>


			<td style="border: 1px solid #666; color:#333; background-color:white; width:45%; text-align:center">
			$item[detalle]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:20%; text-align:center">
			$item[fecha]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:19%; text-align:center">
			$item[nombrecajero]
			</td>

		</tr>

	</table>


EOF;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $bloque4, 0, 1, 0, true, '', true);
	
}




$bloque5 = <<<EOF

	<table style="font-size:9px;  padding:2px 1px;">


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