<?php

    class ControladorPagos{



    //ver todos los pagos realizados 
    static public function ctrMostrarHistorialpagos($item,$valor){

        $tabla="historialpagos";
    
        $respuesta=ModeloPagos::mdlMostrarHistorialpagos($tabla,$item,$valor);
    
        return $respuesta;
        
    }


	
	static public function ctr_ver_tabla_excel($tabla){

    
        $respuesta=ModeloPagos::mdl_ver_tabla_excel($tabla);
    
        return $respuesta;
        
    }




    /*=============================================
	REALIZAR PAGO REGISTRAR PAGO 
	=============================================*/

    static public function ctrRegistrarPagosdeClienteefectivo(){


		if(isset($_POST["editarCliente2"])){
 
				$tabla = "clientes";
 
					$datos = array(
						
								"id"=>$_POST["idCliente2"],
								"nombre"=>$_POST["editarCliente2"],							
								"documento"=>$_POST["editarDocumentoId2"],

							//	"amortizacion"=>$_POST["editarAmortizacion2"],
								"nuevaamortizacion"=>$_POST["editarNuevaAmortizacion2"],
								"afavor"=>$_POST["editarAfavor2"],
								"afavornuevo"=>$_POST["editarAfavor2"] - $_POST["editarAfavorantiguo2"],
								"saldo"=>$_POST["editarSaldo2"],
								"nombrecajero"=>$_SESSION["nombre"],
								"calculofinal"=>$_POST["calculofinal"],


								

								"detalle"=>$_POST["editarNuevaObservacion2"]);
 
					$respuesta = ModeloPagos::mdlRegistrarPagosdeClienteefectivo($tabla, $datos);
 
				  
 
			 
 
					if($respuesta == "ok"){
 
					 echo'<script>
 
					 Swal.fire({
						   type: "success",
						   title: "Pago realizado correctamente!",
						   showConfirmButton: true,
						   confirmButtonText: "Cerrar"
						   }).then(function(result){
									 if (result.value) {
 
									 window.location = "historialpagos";
 
									 }
								 })
 									 window.location = "historialpagos";

					 </script>';
 
				 }
 
 
 
 
		}
 
 
 
 
 
	}









    	/*=============================================
		REALIZAR PAGO REGISTRAR PAGO 
		=============================================*/

		static public function ctrRegistrarPagosclienteBancos(){


			if(isset($_POST["editarCliente2bancos"])){
	
					$tabla = "clientes";
	
						$datos = array(
							
							"id"=>$_POST["idCliente2bancos"],
							"nombre"=>$_POST["editarCliente2bancos"],							
							"documento"=>$_POST["editarDocumentoId2bancos"],

						//	"amortizacion"=>$_POST["editarAmortizacion2"],
							"nuevaamortizacion"=>$_POST["editarNuevaAmortizacion2bancos"],
							"afavor"=>$_POST["editarAfavor2bancos"],
							"afavornuevo"=>$_POST["editarAfavor2bancos"] - $_POST["editarAfavorantiguo2bancos"],
							"saldo"=>$_POST["editarSaldo2bancos"],
							"nombrecajero"=>$_SESSION["nombre"],

							"calculofinal"=>$_POST["calculofinalbanco"],


							"detalle"=>$_POST["editarNuevaObservacion2bancos"]);
	
						$respuesta = ModeloPagos::mdlRegistrarPagosdeClientebancos($tabla, $datos);
	
					
	
				
	
						if($respuesta == "ok"){
	
						echo'<script>
	
						Swal.fire({
							type: "success",
							title: "Pago realizado correctamente!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
							}).then(function(result){
										if (result.value) {
	
										window.location = "historialpagos";
	
										}
									})
										window.location = "historialpagos";

						</script>';
	
					}
	
	
	
	
			}
	
	
	
	
	
		}
		
		
		
			static public function ctrMostrarHistorialpagosreportee($item,$valor){

			$tabla="historialpagosold";
	
			$respuesta=ModeloPagos::mdlMostrarHistorialpagosreporte($tabla,$item,$valor);
	
			return $respuesta;
		
		}
	
	
		static public function ctrMostrarHistorialpagosreporte2e($item,$valor){
	
			$tabla="historialpagosold";
	
			$respuesta=ModeloPagos::mdlMostrarHistorialpagosreporte2($tabla,$item,$valor);
	
			return $respuesta;
		
		}

       
		
		
		
		
		
		
		static public function ctrMostrarHistorialpagosreporte($item,$valor){

			$tabla="historialpagos";
	
			$respuesta=ModeloPagos::mdlMostrarHistorialpagosreporte($tabla,$item,$valor);
	
			return $respuesta;
		
		}
	
	
		static public function ctrMostrarHistorialpagosreporte2($item,$valor){
	
			$tabla="historialpagos";
	
			$respuesta=ModeloPagos::mdlMostrarHistorialpagosreporte2($tabla,$item,$valor);
	
			return $respuesta;
		
		}

        //eliminar pagos de los clientes
		static public function ctrEliminarPagos(){


			if(isset($_GET["idVenta"])){
		
					$tabla = "historialpagos";
		
					$item = "id";
					$valor = $_GET["idVenta"];
		
				//	$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);
					$traerpago= ModeloPagos::mdlMostrarHistorialpagos($tabla, $item, $valor);
					/*=============================================
					ACTUALIZAR FECHA ÚLTIMA COMPRA
					=============================================*/
					
					$metodopago = $traerpago["metodopago"];
	
					
					$dnipago = $traerpago["dni"];
					$cantidadpago = $traerpago["cantidad"];
					$fechapago = $traerpago["fecha"];
					$totalpagocliente = $cantidadpago;
	
	
					if($metodopago == "PAGOCLIENTE"){
						$quitarpago1 = ModeloPagos::mdlActualizarClientePagoeliminar($valor,$dnipago,$cantidadpago,$fechapago,$totalpagocliente);
	
						if($quitarpago1 == "ok"){
		
							echo'<script>
					
							Swal.fire({
								  type: "success",
								  title: "El pago Caja ha sido borrado correctamente",
								  showConfirmButton: true,
								  confirmButtonText: "Cerrar"
								  }).then(function(result){
											if (result.value) {
					
											window.location = "eliminarpagos";
					
											}
										})
											window.location = "eliminarpagos";
	
							</script>';
					
						}
					
						}else{
						if($metodopago == "PAGOCLIENTEBANCO"){
	
							$quitarpago2 = ModeloPagos::mdlActualizarClientePagoeliminarbanco($valor,$dnipago,$cantidadpago,$fechapago,$totalpagocliente);
							if($quitarpago2 == "ok"){
			
								echo'<script>
						
								Swal.fire({
									type: "success",
									title: "El pago Banco ha sido borrado correctamente",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"
									}).then(function(result){
												if (result.value) {
						
												window.location = "eliminarpagos";
						
												}
											})
												window.location = "eliminarpagos";
								</script>';
						
							}
						}
						
					
					}
	
		
	
	/*****************
			if($quitarpago == "ok"){
		
				echo'<script>
		
				Swal.fire({
					  type: "success",
					  title: "El pago ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
		
								window.location = "eliminarpagos";
		
								}
							})
									window.location = "eliminarpagos";
	
				</script>';
	
			}
			******************/
	
	
			//		$tablaClientes = "clientes";
		
			//		$itemVentas = null;
				//	$valorVentas = null;
			//		$montototal = null;
	
		
			//		$traerVentas = ModeloVentas::mdlMostrarVentas($tabla, $itemVentas, $valorVentas);
		
		
				
		
		
		
		
		
		
			}
		
		
		
			
		}
		
		
		
		
		
		
        
    }



?>