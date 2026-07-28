<?php

    class ControladorVerventas{

 
        
        static public function ctrRangoFechasVentasTerminadas($fechaInicial,$fechaFinal){

            $tabla="ventas";

            $respuesta=ModeloVerventas::mdlRangoFechasVentasTerminadas($tabla,$fechaInicial,$fechaFinal);

            return $respuesta;


        }


        static public function ctrMostrarVentas($item,$valor){

            $tabla ="ventas";
    
            $respuesta=ModeloVerventas::mdlMostrarVentas($tabla,$item,$valor);
    
            return $respuesta;
    
    
        }
  
        
    }



?>