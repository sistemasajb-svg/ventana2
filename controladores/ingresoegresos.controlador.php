<?php

    class ControladorIngresoegresos{

		
		static public function ctrMostrarHistorialcajaingresosalida($item,$valor){

			$tabla="historialcaja";
	
			$respuesta=ModeloIngresoegresos::mdlMostrarHistorialingresosalida($tabla,$item,$valor);
	
			return $respuesta;
		
		}


		static public function ctrCrearIngresoPersonaacaja(){

			if(isset($_POST["ingresomontoingreso"])){
		
		
				$tabla="historialcaja";
		
				$datos= array(
						"ingreso" =>$_POST["ingresomontoingreso"],
						"detalle" =>$_POST["detalleingreso"],
						"nuevototalcaja" =>$_POST["nuevomontoactualdecaja"],
						"idcliente" =>$_POST["seleccionarpersonaingreso"],
						"detalleprincipal" =>$_POST["detalleprincipalingreso"],
						"nombrecajero" =>$_SESSION["nombre"],
						"estado" =>$_POST["estadoingreso"],
							);
		
						$respuesta=ModeloIngresoegresos::mdlIngresarcajapersona($tabla,$datos);
		
						if($respuesta == "ok"){
								echo'<script>
		
									Swal.fire({
										type: "success",
										title: "El persona ha sido guardado correctamente",
										showConfirmButton: true,
										confirmButtonText: "Cerrar"
										}).then(function(result){
											if (result.value) {
		
												window.location = "ingresoegreso";
		
											}
										})
											window.location = "ingresoegreso";
										</script>';
		
						}
			
		
		
		
		
			}
		
		
		
		
				
		}
	
		
	
	
		static public function ctrCrearEgresoPersonaacaja(){
		
			if(isset($_POST["ingresoMontosegreso"])){
		
		
				$tabla="historialcaja";
		
				$datos= array(
							"egreso" =>$_POST["ingresoMontosegreso"],
							"detalle" =>$_POST["detalleegreso"],
							"nuevototalcaja" =>$_POST["nuevomontoactualdecajasalida"],
							"idcliente" =>$_POST["seleccionarpersonaegresso"],
							"detalleprincipal" =>$_POST["detalleprincipalegreso"],
							"nombrecajero" =>$_SESSION["nombre"],
							"estado" =>$_POST["estadoegreso"],
						);
		
		
						$respuesta=ModeloIngresoegresos::mdlEgresocajapersona($tabla,$datos);
		
									if($respuesta == "ok"){
		
										echo'<script>
		
										Swal.fire({
											type: "success",
											title: "El persona ha sido guardado correctamente",
											showConfirmButton: true,
											confirmButtonText: "Cerrar"
											}).then(function(result){
														if (result.value) {
		
														window.location = "ingresoegreso";
		
														}
													})
														window.location = "ingresoegreso";
		
										</script>';
		
										}
		
			}
		
		}
	

   
        static public function ctrMostrarIngresoSalidaActualEliminar($item,$valor){

			$tabla="historialcaja";
		
			$respuesta=ModeloIngresoegresos::mdlMostrarIngresoSalidaActualEliminar($tabla,$item,$valor);
		
			return $respuesta;
	
		}

		
		static public function ctrEliminaringresosegresos(){


			if(isset($_GET["idVenta"])){

					$tabla = "historialcaja";

					$item = "id";
					$valor = $_GET["idVenta"];

				//	$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);
					$traerpago= ModeloIngresoegresos::mdlMostrarIngresoSalidaActualEliminar($tabla, $item, $valor);
					/*=============================================
					ACTUALIZAR FECHA ÚLTIMA COMPRA
					=============================================*/
					
					
					$metodopago = $traerpago["tipo"];

					$dni = $traerpago["dni"];
					$ingreso = $traerpago["ingreso"];
					$salida = $traerpago["salida"];
					$fechapago = $traerpago["fecha"];

					if($metodopago == "INGRESO CAJA"){
						$quitarpago1 = ModeloIngresoegresos::mdlActualizarIngresoEliminar($valor,$dni,$ingreso,$salida,$fechapago);

						if($quitarpago1 == "ok"){

							echo'<script>
					
							Swal.fire({
								type: "success",
								title: "El Ingreso a Caja ha sido borrado correctamente",
								text: "El monto sera retirado de caja, Efectivo",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
									}).then(function(result){
										if (result.value) {
					
										window.location = "eliminaringresosegresos";
					
										}
									})
										window.location = "eliminaringresosegresos";

							</script>';
						}
					
						}else{
						if($metodopago == "EGRESO CAJA"){

							$quitarpago2 = ModeloIngresoegresos::mdlActualizarEgresoEliminar($valor,$dni,$ingreso,$salida,$fechapago);
							if($quitarpago2 == "ok"){
			
								echo'<script>
						
								Swal.fire({
									type: "success",
									title: "El Egreso ha sido borrado correctamente",
									text: "El monto sera devuelto a caja, Efectivo",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"
									}).then(function(result){
												if (result.value) {
						
												window.location = "eliminaringresosegresos";
						
												}
											})
											window.location = "eliminaringresosegresos";

								</script>';
						
							}
						}
						
					
					}




				//		$tablaClientes = "clientes";

				//		$itemVentas = null;
					//	$valorVentas = null;
				//		$montototal = null;


				//		$traerVentas = ModeloVentas::mdlMostrarVentas($tabla, $itemVentas, $valorVentas);


					






			}



			
		}


        static public function ctrfiltrarcajaingresosalida($item,$valor,$fecha1,$fecha2){

			$tabla="historialcaja";
	
			$respuesta=ModeloIngresoegresos::mdlfiltraringresosalida($tabla,$item,$valor,$fecha1,$fecha2);
	
			return $respuesta;
		
		}

		

        
	}



?>