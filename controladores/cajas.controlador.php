<?php

    class ControladorCajas{

        
        /*=============================================
        MOSTRAR CAJAS
        =============================================*/

        static public function ctrMostrarCajas($item,$valor){
            $tabla="caja";
            $respuesta=ModeloCajas::mdlMostrarCajas($tabla,$item,$valor);
            return $respuesta;
        }

        /*=============================================
        MOSTRAR MONTO ACTUAL DE LA CAJA PARA CREAR OTRA CAJA
        =============================================*/
        
        static public function ctrMostrarCajasmonto($item,$valor){
            $tabla="caja";
            $respuesta=ModeloCajas::mdlMostrarCajasmonto($tabla,$item,$valor);
            return $respuesta;
        }
        
        /*=============================================
        REGISTRO NUEVA CAJA
        =============================================*/

        static public function ctrCrearCajas(){
            if(isset($_POST["nuevoMonto"])){

    
                    $ruta="";

                        $tabla="caja";



                        $datos=array(

                            "caja"=>$_POST["nuevoMonto"],
                            "cajero"=>$_SESSION["nombre"],
                            "detallecaja"=>$_POST["nuevodetallecaja"]);

    
                            $respuesta=ModeloCajas::mdlIngresarCajas($tabla,$datos);


                            if($respuesta=="ok"){

                                echo "<script>

                                    Swal.fire({
                                            title: 'se creo correctamente la caja',
                                            icon: 'success',
                                            }).then((result) => {
                                                                    
                                                window.location = 'cajas';
                                                                    
                                            })
                                                window.location = 'cajas';
        
                                    </script>";






                            }else{
                                
                                if($respuesta=="activo"){

                                echo "<script>

        alert('No es posible aperturar una nueva caja, ya existe una caja activa.');
                                                        window.location = 'cajas';


                                    </script>";






                            }
                                
                            }
                            
            }


        }



        //hitorial de caja para reporte PDF
        static public function ctrMostrarHistorialcajas($item,$valor){
            
            $rr = ModeloCajas::mdlActualizarDetallePrincipal();

            $tabla="historialcaja";
    
            $respuesta=ModeloCajas::mdlMostrarHistorialcajas($tabla,$item,$valor);
    
            return $respuesta;
        
        }
        
        static public function ctrMostrarHistorialcajas7fe($item,$valor){

            $tabla="historialcaja";
    
            $respuesta=ModeloCajas::mdlMostrarHistorialcajas7fe($tabla,$item,$valor);
    
            return $respuesta;
        
        }
    
        //buscar historial para reporte de caja PDF
        static public function ctrMostrarHistorialcajas2($item,$valor){
    
            $tabla="caja";
    
            $respuesta=ModeloCajas::mdlMostrarHistorialcajas2($tabla,$item,$valor);
    
            return $respuesta;
        
        }


        //buscar historial para ingreso egreso de caja PDF
        static public function ctrIngresEgrescajas($item, $valor)
        {
            $respuesta = ModeloCajas::mdlIngresEgrescajas($item, $valor);
    
            return $respuesta;
        }
    




    }




?>