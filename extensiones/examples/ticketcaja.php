<?php



require_once "../../controladores/ingresoegresos.controlador.php";
require_once "../../modelo/ingresoegresos.modelo.php";



class imprimirFactura{

public $codigo;

public function traerImpresionFactura(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemVenta = "id";
$valorVenta = $this->codigo;

$respuestaVenta = ControladorIngresoegresos::ctrMostrarHistorialcajaingresosalida($itemVenta, $valorVenta);



//<td>'.$value["cliente"].'</td>
//<td>'.$value["dni"].'</td>
//<td>'.$value["tipo"].'</td>
//<td>'.$value["ingreso"].'</td>
//<td>'.$value["salida"].'</td>
//<td>'.$value["detalle"].'</td>
//<td>'.$value["estado"].'</td>
//<td>'.$value["fecha"].'</td>


$cliente = ($respuestaVenta["cliente"]);
$id = ($respuestaVenta["id"]);
$dni = ($respuestaVenta["dni"]);
$tipo = ($respuestaVenta["tipo"]);
$ingreso = ($respuestaVenta["ingreso"]);
$salida = ($respuestaVenta["salida"]);
$detalle = ($respuestaVenta["detalle"]);
$detalleprincipal = ($respuestaVenta["detalleprincipal"]);
$estado = ($respuestaVenta["estado"]);
$fecha = ($respuestaVenta["fecha"]);
$nombrecajero = ($respuestaVenta["nombrecajero"]);

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

			ESTADO:$estado Cod.$id 
			<br><br>

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
			- INGRESO : S/.$ingreso 
		</td>

		<td style="width:100px;">
		</td>
	</tr>




	<tr>
		<td style="width:160px;">
			- SALIDA  : S/.$salida
		</td>

		<td style="width:1200px;">
		</td>

	</tr>

	<tr>
		<td style="width:160px;">
		-------------------------------------------------
		</td>
	</tr>

	<tr>
	

		<td style="width:160px;">
		$tipo: $detalleprincipal
		</td>
		
	</tr>
	<tr>
		<td style="width:160px;">
		$detalle

		-------------------------------------------------
		</td>
	</tr>
	<br>

	

	<tr>
	<br>
<br>
<br>

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