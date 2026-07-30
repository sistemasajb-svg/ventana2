<?php

error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
if (ob_get_level()) ob_end_clean();

require_once "../../controladores/pagos.controlador.php";
require_once "../../modelo/pagos.modelo.php";



class imprimirFactura{

public $codigo;

public function traerImpresionFactura(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemVenta = "id";
$valorVenta = $this->codigo;

$respuestaVenta = ControladorPagos::ctrMostrarHistorialpagos($itemVenta, $valorVenta);

$fecha = ($respuestaVenta["fecha"]);
$idpago = ($respuestaVenta["id"]);
$cliente = ($respuestaVenta["cliente"]);
$dni = ($respuestaVenta["dni"]);
$montopagado = ($respuestaVenta["cantidad"]) + ($respuestaVenta["afavor"]);
$afavor = ($respuestaVenta["afavor"]);
$detalle = ($respuestaVenta["detalle"]);
$nombrecajero = ($respuestaVenta["nombrecajero"]);

$neto = number_format($respuestaVenta["afavor"],2);
$impuesto = number_format($respuestaVenta["cantidad"],2);

//TRAEMOS LA INFORMACIÓN DEL CLIENTE

//$itemCliente = "id";
//$valorCliente = $respuestaVenta["id_cliente"];

//$respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

//TRAEMOS LA INFORMACIÓN DEL VENDEDOR

//$itemVendedor = "id";
//$valorVendedor = $respuestaVenta["id_vendedor"];

//$respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);

//REQUERIMOS LA CLASE TCPDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage('P', 'A7');

//---------------------------------------------------------




$bloque1 = <<<EOF

<table style="font-size:9px; text-align:center">

	
	<tr>		
		<td style="width:160px;">
			<div>

			¡PAGO EXITOSO! N° $idpago 
			<br>
			Fecha: $fecha
<br>
			
			
			</div>

		</td>

	</tr>


</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

// ---------------------------------------------------------



// ---------------------------------------------------------

$bloque3 = <<<EOF


<table style="font-size:9px; text-align:left">


	<tr>
		<td style="width:160px;">
			- Monto pagado : S/.$montopagado 
		</td>

		<td style="width:100px;">
		</td>
	</tr>




	<tr >
	
	</tr>

	<tr>
		<td style="width:160px;">
		-------------------------------------------------
		</td>
	</tr>

	<tr>
	

		<td style="width:160px;">
		Detalle:  $detalle
		</td>

	</tr>
	<tr>
		<td style="width:160px;">
		-------------------------------------------------
		</td>
	</tr>
	<br><br><br><br>

	

	<tr>
	
	<td style="width:80px;">
	______________
	</td>

	<td style="width:80px;">
	______________
	</td>

</tr>



<tr>

	<td style="width:80px;">
		Caja: $nombrecajero
	</td>

	<td style="width:80px;">
		Cli: $cliente - $dni
	</td>
	<br>

</tr>
<br>
<br>

	<tr>
		<td style="width:160px;text-align: center ">
		</td>
	</tr>

</table>



EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 

//$pdf->Output('factura.pdf', 'D');
ob_end_clean();
$pdf->Output('factura.pdf');

}

}

$factura = new imprimirFactura();
$factura -> codigo = $_GET["id"];
$factura -> traerImpresionFactura();
?>