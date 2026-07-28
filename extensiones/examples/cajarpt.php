<?php


require_once "../../controladores/cajas.controlador.php";
require_once "../../modelo/cajas.modelo.php";




class  imprimirFactura{


public $id;

public function traerImpresionFactura2(){


//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemVenta = "id";
$valorVenta = $this->id;

$respuestaVenta = ControladorCajas::ctrMostrarHistorialcajas7fe($itemVenta, $valorVenta);
$respuestaVenta7febrero = ControladorCajas::ctrMostrarHistorialcajas($itemVenta, $valorVenta);
$respuestaVenta2 = ControladorCajas::ctrMostrarHistorialcajas2($itemVenta, $valorVenta);
$ingresoegreso = ControladorCajas::ctrIngresEgrescajas($itemVenta,$valorVenta);



$id2 = ($respuestaVenta2["id"]);
$caja2 = ($respuestaVenta2["caja"]);
$estado2 = ($respuestaVenta2["estado"]);
$fecha2 = ($respuestaVenta2["fecha"]);
$banco2 = ($respuestaVenta2["banco"]);
$fechacierre2 = ($respuestaVenta2["fechacierre"]);
$detallecaja2 = ($respuestaVenta2["detallecaja"]);
$cajero2 = ($respuestaVenta2["cajero"]);

$ingresocaja = ($ingresoegreso["suma_ingreso_caja"]);
		$egresocaja = ($ingresoegreso["suma_egreso_caja"]);



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
			<td style="background-color:white; width:85%; text-align:center;font-weight: bold;
			 font-size: 150%; color:green">REPORTE DE CAJA</td>
			<td style="background-color:white; width:15%; text-align:center; color:green">CODIGO.<br>$valorVenta</td>

			<br>
			
		</tr><br>
		<tr>
		


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

	<table style="font-size:10px; padding:5px 10px;">
	
		
		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:50% ">

				ENCARGADO DE CAJA: $cajero2 

			</td>

			<td style="border: 1px solid #666; background-color:white; width:50%; text-align:center">
			
				FECHA APERTURA: $fecha2 

			</td>

		</tr>

	

	</table>

	<table style="font-size:10px; padding:5px 10px;">
	
	<tr>
	
		<td style="border: 1px solid #666; background-color:white; width:50% ">

		ESTADO : $estado2

		</td>

		<td style="border: 1px solid #666; background-color:white; width:50%; text-align:center">
		
		FECHA CIERRE: $fechacierre2

		</td>

	</tr>	
	
	<tr>
	
		

		<td style="border: 1px solid #666; background-color:white; width:100%;font-size:15px;;text-align:center">
		
		MONTO TOTAL CAJA EJECTIVO: S/.$caja2 

		</td>
		
		
		

	</tr>

	 
	
	<tr>
	
		<td style="border: 1px solid #666; background-color:white; width:100%;font-size:15px;;text-align:center">
		Ingreso caja: S/.$ingresocaja
		</td>
		
	</tr>
	<tr>
	
		<td style="border: 1px solid #666; background-color:white; width:100%;font-size:15px;;text-align:center">
		Egreso caja: S/.$egresocaja
		</td>
		
	</tr>


</table>


<br>
<br>


EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $bloque2, 0, 1, 0, true, '', true);


$bloque3 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
		
		<td style="border: 1px solid #666; background-color:white; width:12%; text-align:center">TIPO</td>
		<td style="border: 1px solid #666; background-color:white; width:10%; text-align:center">CLIENTE</td>
		<td style="border: 1px solid #666; background-color:white; width:11%; text-align:center">DNI</td>
		<td style="border: 1px solid #666; background-color:white; width:12%; text-align:center">INGRESO</td>
		<td style="border: 1px solid #666; background-color:white; width:12%; text-align:center">SALIDA</td>
		<td style="border: 1px solid #666; background-color:white; width:25%; text-align:center">DETALLE</td>
		<td style="border: 1px solid #666; background-color:white; width:12%; text-align:center">FECHA</td>
		<td style="border: 1px solid #666; background-color:white; width:10%; text-align:center">CAJA</td>

		</tr>

	</table>

EOF;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $bloque3, 0, 1, 0, true, '', true);

foreach ($respuestaVenta  as $key => $item) {

$bloque4 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
			
			


			<td style="border: 1px solid #666; color:#333; background-color:white; width:12%; text-align:center">
			$item[tipo]
			</td>
			
			
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:10%; text-align:center">
			$item[cliente]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:11%; text-align:center">
			$item[dni]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:12%; text-align:center">
			$item[ingreso]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:12%; text-align:center">
			$item[salida]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:25%; text-align:center">
			$item[detalle]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:12%; text-align:center">
			$item[fecha]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:10%; text-align:center">
			$item[nombrecajero]
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
$factura -> traerImpresionFactura2();