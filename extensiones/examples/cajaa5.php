<?php

error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
if (ob_get_level()) ob_end_clean();

require_once "../../controladores/cajas.controlador.php";
require_once "../../modelo/cajas.modelo.php";


session_start();


if (!isset($_SESSION["usuario"])) {
	header("Location: ../../../login");
	exit();
}



class imprimirFactura
{



	public $id;

	public function traerImpresionFactura2()
	{


		//TRAEMOS LA INFORMACIÓN DE LA VENTA
		$itemVenta = "id";
		$valorVenta = $this->id;

		$respuestaVenta = ControladorCajas::ctrMostrarHistorialcajas7fe($itemVenta, $valorVenta);
		$respuestaVenta7febrero = ControladorCajas::ctrMostrarHistorialcajas($itemVenta, $valorVenta);
		$respuestaVenta2 = ControladorCajas::ctrMostrarHistorialcajas2($itemVenta, $valorVenta);
		$ingresoegreso = ControladorCajas::ctrIngresEgrescajas($itemVenta, $valorVenta);


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


		$usuarioimprimido = isset($_SESSION["nombre"]) ? $_SESSION["nombre"] : "nombre no identificado";  // Maneja si no hay usuario en sesión


		//Include the main TCPDF library (search for installation path).
		require_once('tcpdf_include.php');

	    // Create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);


        $pdf->setPrintFooter(false);  // Esto elimina el contador de páginas en el pie

        // Set margins
		$pdf->setMargins(10, 5, 10);  // Ajusta los márgenes (izquierda, arriba, derecha)
		$pdf->setHeaderMargin(2);  // Reduce el margen de la cabecera
		$pdf->setFooterMargin(10);  // Ajusta el margen inferior si es necesario


		// set auto page breaks
		$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


		// Set language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // Set default font subsetting mode
		$pdf->setFontSubsetting(true);

		$pdf->setFont('dejavusans', '', 14, '', true);

        // Add a page
		$pdf->AddPage();

		// set text shadow effect
		$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));


		$fechaFormateada = date("d M Y H:i", strtotime($fecha2));



		// Set some content to print
		$bloque1 = <<<EOD



	<table>

		<tr style="font-size:11px;">
			<td style="border: 1px solid #666; background-color:#F2F2F2; width:31%; text-align:center; font-weight:bold; color:#333;">CAJA: $valorVenta</td>
			<td style="border: 1px solid #666; background-color:#F9F9F9; width:24%; text-align:center; font-weight:bold; color:#333;">INGRESOS:</td>
			<td style="border: 1px solid #666; background-color:#F9F9F9; width:24%; text-align:center; font-weight:bold; color:#333;">EGRESOS:</td>
			<td style="border: 1px solid #666; background-color:#F2F2F2; width:23%; text-align:center; font-weight:bold; color:#333;">SALDO FINAL:</td>
		</tr>

		<tr>
			<td style="font-size: 12px; border: 1px solid #666; background-color:white; width:31%; text-align:center">$fechaFormateada</td>
			<td style="font-size: 12px; border: 1px solid #666; background-color:white; width:24%; text-align:center">S/.$ingresocaja</td>
			<td style="font-size: 12px; border: 1px solid #666; background-color:white; width:24%; text-align:center">S/.$egresocaja</td>
			<td style="font-size: 12px; border: 1px solid #666; background-color:white; width:23%; text-align:center">S/.$caja2</td>

			<br>
			
		</tr>

		 
		<tr>
		


		</tr>

	</table>


EOD;

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell(0, 0, '', '', $bloque1, 0, 1, 0, true, '', true);

		// Check if we've used half of the page, if yes, add a new page
        if ($pdf->GetY() > ($pdf->getPageHeight() / 2)) {
            $pdf->AddPage();
            $pdf->SetY(10);
        }

		// Set some content to print
		$bloque2 = <<<EOD


	<table>
		
		<tr>
	
		</tr>

	</table>


EOD;

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell(0, 0, '1', '18', $bloque2, 0, 1, 0, true, '', true);


		$bloque3 = <<<EOF

	<table>

		<tr>
			<td style="font-size:9px; border: 1px solid #666; background-color:white; width:6%; text-align:center; font-weight:bold;">Ticket</td>
			<td style="font-size:9px; border: 1px solid #666; background-color:white; width:9%; text-align:center; font-weight:bold;">Tipo</td>
			<td style="font-size:9px; border: 1px solid #666; background-color:white; width:12%; text-align:center; font-weight:bold;">Cliente</td>
			<td style="font-size:10px; border: 1px solid #666; background-color:white; width:8%; text-align:center; font-weight:bold;">Ingreso</td>
			<td style="font-size:10px; border: 1px solid #666; background-color:white; width:8%; text-align:center; font-weight:bold;">Egreso</td>
			<td style="font-size:10px; border: 1px solid #666; background-color:white; width:20%; text-align:center; font-weight:bold;">Motivo Principal</td>
			<td style="font-size:10px; border: 1px solid #666; background-color:white; width:29%; text-align:center; font-weight:bold;">Detalle</td>
			<td style="font-size:9px; border: 1px solid #666; background-color:white; width:10%; text-align:center; font-weight:bold;">Enc. & Hr.</td>
		</tr>


	</table>
	

EOF;

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell(0, 0, '', '16', $bloque3, 0, 1, 0, true, '', true);

		foreach ($respuestaVenta as $key => $item) {

			$solohora = date("H:i", strtotime($item['fecha']));  // Solo hora y minutos
			$cerrarpendiente = $item['cerrarpendiente'];
			$itemtipo = $item["tipo"];
			$itemdetalleprincipal = $item["detalleprincipal"];



			/*******************$mitadHoja = $pdf->getPageHeight() / 2;
			if ($pdf->GetY() > $mitadHoja) {
				$pdf->AddPage();
				$pdf->SetY(10);
				$pdf->writeHTMLCell(0, 0, '', '', $bloque3, 0, 1, 0, true, '', true);
			}*****************/
			
			$mitadHoja = $pdf->getPageHeight() / 2;
$alturaFilaEstimado = 10; // puedes ajustar si tus filas ocupan más

if ($pdf->GetY() + $alturaFilaEstimado > $mitadHoja) {
    $pdf->AddPage();
    $pdf->SetY(10);
	$pdf->writeHTMLCell(0, 0, '', '0', $bloque3, 0, 1, 0,true,'0',true);
}
			
			
			// if ($cerrarpendiente == "CIERRE Pendiente" || $cerrarpendiente == "EN PROCESO") {
			// 	$itemtipo = "EN PROCESO";
			// }

			if ($item["estado"] == "salidaenproceso") {
				$itemtipo = "EN PROCESO";
			}

			if ($cerrarpendiente == "CERRADO") {

				$itemdetalleprincipal = $item["detalleprincipal"] . "-" . "CERRADO";
				$itemtipo = $item["tipo"] . "CERRADO";

			}

			if ($itemtipo == "INGRESO CAJA PENDIENTE") {

				$itemtipo = "I-CIERRE PENDIENTE";
				$itemdetalleprincipal = $item["detalleprincipal"] . "-" . "<br>Ticket" . $cerrarpendiente;


			}

			if ($itemtipo == "EGRESO CAJA PENDIENTE") {

				$itemtipo = "E-CIERRE Pendiente";
				$itemdetalleprincipal = $item["detalleprincipal"] . "-" . "<br>Ticket" . $cerrarpendiente;

			}

			$bloque4 = <<<EOF

	<table  >

		<tr>			
			
			<td style="font-size:7px; border: 1px solid #666; color:#333; background-color:white; width:6%; text-align:center">
			$item[id]
			</td>
			
						
			<td style="font-size:7px; border: 1px solid #666; color:#333; background-color:white; width:9%; text-align:center">
			$itemtipo
			</td>

			<td style="font-size:10px; border: 1px solid #666; color:#333; background-color:white; width:12%; text-align:center">
			$item[cliente]
			</td>

			<td style="font-size:10px; border: 1px solid #666; color:#333; background-color:white; width:8%; text-align:center">
			$item[ingreso]
			</td>

			<td style="font-size:10px; border: 1px solid #666; color:#333; background-color:white; width:8%; text-align:center">
			$item[salida]
			</td>

			<td style="font-size:9px;border: 1px solid #666; color:#333; background-color:white; width:20%; text-align:center">
			$itemdetalleprincipal
			</td>

			<td style="font-size:9px; border: 1px solid #666; color:#333; background-color:white; width:29%; text-align:center">
			$item[detalle]
			</td>
 

			<td style="font-size:6px; border: 1px solid #666; color:#333; background-color:white; width:10%; text-align:center">
			$item[nombrecajero] $solohora
			</td>

		</tr>

	</table>


EOF;

			// Print text using writeHTMLCell()
			$pdf->writeHTMLCell(0, 0, '', '', $bloque4, 0, 1, 0, true, '', true);


			
		}
		


		// Obtén la fecha y hora actual
$fechaHoraActual = date("d-m-Y H:i");  // Formato: Día Mes Año Hora:Minuto

// Añadir al bloque final de la tabla HTML
$bloqueFinal = <<<EOD

	<tr>
		<td colspan="8" style="font-size:12px; border: 1px solid #666; background-color:#F2F2F2; text-align:center; font-weight:bold; color:#333;">
			$fechaHoraActual - $usuarioimprimido
		</td>
	</tr>

EOD;

// Luego, lo añades al contenido de la tabla
$pdf->writeHTMLCell(0, 0, '', '', $bloqueFinal, 0, 1, 0, true, '', true);




		$pdf->Output('factura.pdf', 'I');


	}





}


$factura = new imprimirFactura();
$factura->id = $_GET["id"];
$factura->traerImpresionFactura2();


		