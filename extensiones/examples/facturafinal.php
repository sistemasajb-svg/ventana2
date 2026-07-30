<?php

error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
if (ob_get_level()) ob_end_clean();

require_once "../../controladores/personas.controlador.php";
require_once "../../modelo/personas.modelo.php";

require_once "../../controladores/clientes.controlador.php";
require_once "../../modelo/clientes.modelo.php";

require_once "../../controladores/usuarios.controlador.php";
require_once "../../modelo/usuarios.modelo.php";






class  imprimirFactura{


public $codigo;

public function traerImpresionFactura(){


//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemVenta = "codigo";
$valorVenta = $this->codigo;


$respuestaVenta = ControladorPersonas::ctrMostrarVentas($itemVenta, $valorVenta);


$fecha = substr($respuestaVenta["fecha"],0,-8);
$productos = json_decode($respuestaVenta["productos"], true);
$neto = number_format($respuestaVenta["neto"],2);
$impuesto = number_format($respuestaVenta["impuesto"],2);
$total = number_format($respuestaVenta["total"],2);



//TRAEMOS LA INFORMACIÓN DEL CLIENTE

$itemCliente = "id";
$valorCliente = $respuestaVenta["id_cliente"];

$respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);



//TRAEMOS LA INFORMACIÓN DEL VENDEDOR

$itemVendedor = "id";
$valorVendedor = $respuestaVenta["id_vendedor"];

$respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);












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

			<td style="background-color:white; width:40%; text-align:center; color:red"><br><br>   VENTA Nº.$valorVenta</td>

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

	<table style="font-size:10px; padding:5px 10px; ">
	
		<tr>
		
			<td style="border: 1px solid #666; font-weight: bolder; background-color:white; width:70%">

				Cliente: $respuestaCliente[nombre]

			</td>

			<td style="border: 1px solid #666;  font-weight: bolder; background-color:white; width:30%; text-align:right">
			
				Fecha: $fecha

			</td>

		</tr>

		<tr>
		
			<td style="border: 1px solid #666;  font-weight: bolder; background-color:white; width:100%">Vendedor: $respuestaVendedor[nombre]</td>

		</tr>

		<tr>
		
		<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>

		</tr>

	</table>




EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $bloque2, 0, 1, 0, true, '', true);


$bloque3 = <<<EOF

	<table style="font-size:10px; font-weight: bolder; padding:5px 10px;">

		<tr>
		
		<td style="border: 1px solid #666; background-color:white; width:18%; text-align:center">Producto</td>
		<td style="border: 1px solid #666; background-color:white; width:14%; text-align:center">huevos</td>
		<td style="border: 1px solid #666; background-color:white; width:10%; text-align:center">Jaba</td>
		<td style="border: 1px solid #666; background-color:white; width:9%; text-align:center">Celda</td>
		<td style="border: 1px solid #666; background-color:white; width:15%; text-align:center">Peso</td>
		<td style="border: 1px solid #666; background-color:white; width:14%; text-align:center">Valor Unit.</td>
		<td style="border: 1px solid #666; background-color:white; width:20%; text-align:center">Valor Total</td>

		</tr>

	</table>

EOF;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $bloque3, 0, 1, 0, true, '', true);

foreach ($productos as $key => $item){

$itemProducto = "descripcion";
$valorProducto = $item["descripcion"];
$orden = null;

$respuestaProducto = ControladorPersonas::ctrMostrarProductos($itemProducto, $valorProducto, $orden);
$segundonombre = ($respuestaProducto["descripcion2"]);

$valorUnitario = number_format($respuestaProducto["precio_venta"], 2);

$precioTotal = number_format($item["total"], 2);


$bloque4 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:18%; text-align:center">
				$segundonombre
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:14%; text-align:center"> 
				$item[cantidad]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:10%; text-align:center"> 
			$item[cantidadjaba]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:9%; text-align:center"> 
			$item[cantidadcelda]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:15%; text-align:center"> 
			$item[peso]
			</td>


			<td style="border: 1px solid #666; color:#333; background-color:white; width:14%; text-align:center">S/ 
			$item[preciooriginal]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:20%; text-align:center">S/ 
			$item[subtotal]
			</td>


		</tr>

	</table>


EOF;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $bloque4, 0, 1, 0, true, '', true);
	
}




$bloque5 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>

			<td style="color:#333; background-color:white; width:68%; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>

		</tr>
		
		

		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:60%; text-align:center"></td>

			<td style="border: 1px solid #666;  font-weight: bolder; background-color:white; width:110px; text-align:center">
				Total:
			</td>
			
			<td style="border: 1px solid #666; color:#333;  font-weight: bolder; background-color:white; width:140px; text-align:center">
				S/ $total
			</td>

		</tr>


	</table>

EOF;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $bloque5, 0, 1, 0, true, '', true);







$pdf->Output('factura.pdf', 'I');


		}





}


$factura = new imprimirFactura();
$factura -> codigo = $_GET["codigo"];
$factura -> traerImpresionFactura();