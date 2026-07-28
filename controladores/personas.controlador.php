<?php 

class ControladorPersonas{


    static public function ctrMostrarPersonas($item,$valor){

        $tabla="personas";


        $respuesta=ModeloPersonas::mdlMostrarPersonas($tabla,$item,$valor);


        return $respuesta;
    
    }


    static public function ctrCrearPersona(){

        if(isset($_POST["nuevoPersona2"])){


            $tabla="personas";

            $datos= array("nombre" =>$_POST["nuevoPersona2"],
                        "documento" =>$_POST["nuevoDocumentoId2"],
                        "email" =>$_POST["nuevoEmail2"],
                        "telefono" =>$_POST["nuevoTelefono2"],
                        "direccion" =>$_POST["nuevaDireccion2"],
                        "fechacreacion" =>$_POST["nuevaFechaCreacion2"] );


                        $respuesta=ModeloPersonas::mdlIngresarPersona($tabla,$datos);

                          	if($respuesta == "ok"){

                                echo'<script>

                                Swal.fire({
                                    type: "success",
                                    title: "El persona ha sido guardado correctamente",
                                    showConfirmButton: true,
                                    confirmButtonText: "Cerrar"
                                    }).then(function(result){
                                                if (result.value) {

                                                window.location = "personas";

                                                }
                                            })
                                                window.location = "personas";

                                </script>';

				}
       




        }




        
    }

 
    static public function ctrEditarPersona(){


        if(isset($_POST["editarPersonaeditar"])){
 
                $tabla = "personas";
 
                    $datos = array("id"=>$_POST["idPersona"],
                                   "nombre"=>$_POST["editarPersonaeditar"],
                                "documento"=>$_POST["editarDocumentoIdeditar"],
                                "email"=>$_POST["editarEmaileditar"],
                                "telefono"=>$_POST["editarTelefonoeditar"],
                                "direccion"=>$_POST["editarDireccioneditar"],
                                "fechacreacion"=>$_POST["nuevaFechaCreacioneditar"]);
 
                    $respuesta = ModeloPersonas::mdlEditarPersona($tabla, $datos);
 
                  
 
             
 
                    if($respuesta == "ok"){
 
                        echo'<script>
    
                        Swal.fire({
                            type: "success",
                            title: "La persona ha sido cambiado correctamente",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                            }).then(function(result){
                                        if (result.value) {
    
                                        window.location = "personas";
    
                                        }
                                    })
                                    window.location = "personas";

                        </script>';
    
                    }
 
 
 
 
        }
 
 
 
 
 
    }


}




?>