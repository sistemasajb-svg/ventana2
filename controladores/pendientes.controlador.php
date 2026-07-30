<?php 

class ControladorPendientes{

    static public function ctrCrearPendiente(){

        if(isset($_POST["nuevoPendiente"])){


            $tabla="historialcaja";

            $datos= array("nombre" =>$_POST["nuevoPendiente"],
                        "documento" =>$_POST["nuevoDocumentoId"],
                        "email" =>$_POST["nuevoEmail"],
                        "telefono" =>$_POST["nuevoTelefono"],
                        "direccion" =>$_POST["nuevaDireccion"],
                        "fecha_nacimiento" =>$_POST["nuevaFechaNacimiento"] );


                        $respuesta=ModeloPendientes::mdlIngresarPendiente($tabla,$datos);

                          	if($respuesta == "ok"){

                                echo'<script>

                                Swal.fire({
                                    type: "success",
                                    title: "El pendiente ha sido guardado correctamente",
                                    showConfirmButton: true,
                                    confirmButtonText: "Cerrar"
                                    }).then(function(result){
                                                if (result.value) {

                                                window.location = "pendientes";

                                                }
                                            })

                                </script>';

				}
       




        }




        
    }






    static public function ctrMostrarPendientes($item,$valor){

        $tabla="historialcaja";


        $respuesta=ModeloPendientes::mdlMostrarPendientes($tabla,$item,$valor);


        return $respuesta;
    
    }



    	/*=============================================
	EDITAR PENDIENTE INGRESO
	=============================================*/

    static public function ctrEditarPendienteegreso(){


		if(isset($_POST["idPendienteegreso"])){
 
				$tabla = "historialcaja";
 
					$datos = array(
							 "id"=>$_POST["idPendienteegreso"],
							 "editardetallesegundo"=>$_POST["editardetallesegundo"],
							 "ingreso" =>$_POST["cantidadingresopendienteagregaregreso"],
							 "detalle" =>$_POST["editardetallesegundoegreso"],
							 "nuevototalcaja" =>$_POST["cantidadingresopendienteagregaregreso"],
							 "dnicliente" =>$_POST["editardniclienteegreso"],
							 "nombrecliente" =>$_POST["editarnombreclienteegreso"],
							 "detalleprincipal" =>$_POST["editardetalleprincipalegreso"],
							 "nombrecajero" =>$_SESSION["nombre"],
							 "estado" =>"Terminado",
					  );
 
					$respuesta = ModeloPendientes::mdlEditarPendienteegreso($tabla, $datos);
 
				  
 
			 
 
					if($respuesta == "ok"){
 
					 echo'<script>
 
					 Swal.fire({
						   type: "success",
						   title: "El pendiente ha sido cambiado correctamente",
						   showConfirmButton: true,
						   confirmButtonText: "Cerrar"
						   }).then(function(result){
									 if (result.value) {
 
									 window.location = "pendientes";
 
									 }
								 })
                                 window.location = "pendientes";

					 </script>';
 
				 }
 
 
 
 
		 }
 
 
 
 
 
	 }

    	/*=============================================
	EDITAR PENDIENTE EGRESO
	=============================================*/

    static public function ctrEditarPendiente(){


		if(isset($_POST["editarPendiente"])){
 
				$tabla = "historialcaja";
 
					$datos = array(
							 "id"=>$_POST["id"],
							 "estadopendientes"=>$_POST["estadopendientes"],
							 "editardetallesegundo"=>$_POST["editardetallesegundo"],
							 "ingreso" =>$_POST["cantidadingresopendienteagregar"],
							 "detalle" =>$_POST["editardetallesegundo"],
							 "nuevototalcaja" =>$_POST["cantidadingresopendienteagregar"],
							 "dnicliente" =>$_POST["editardnicliente"],
							 "nombrecliente" =>$_POST["editarnombrecliente"],
							 "detalleprincipal" =>$_POST["editardetalleprincipal"],
							 "nombrecajero" =>$_SESSION["nombre"],
							 "estado" =>"Terminado",
					  );
 
					$respuesta = ModeloPendientes::mdlEditarPendiente($tabla, $datos);
 
				  
 
			 
 
					if($respuesta == "ok"){
 
					 echo'<script>
 
					 Swal.fire({
						   type: "success",
						   title: "El pendiente ha sido cambiado correctamente",
						   showConfirmButton: true,
						   confirmButtonText: "Cerrar"
						   }).then(function(result){
									 if (result.value) {
 
									 window.location = "pendientes";
 
									 }
								 })
                                 window.location = "pendientes";

					 </script>';
 
				 }
 
 
 
 
		 }
 
 
 
 
 
	 }
  

	

  
  
  
  




}




?>