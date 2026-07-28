<?php

    class ControladorPagoMasivo{
               
        static public function ctrcodigomasivo(){
            $tabla="historialpagos";
            $respuesta=ModeloPagoMasivo::mdlcodigomasivo($tabla);
            return $respuesta;
        }

        static public function ctrMostrarClientes(){
            $tabla="clientes";
            $respuesta=ModeloPagoMasivo::mdlMostrarClientesTrabajador($tabla);
            return $respuesta;  
        }


    }




?>