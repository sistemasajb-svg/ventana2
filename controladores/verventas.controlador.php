<?php

require_once "controladores/clientes.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "modelo/clientes.modelo.php";
require_once "modelo/usuarios.modelo.php";
require_once "modelo/verventas.modelo.php";

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


        static public function ctrListarVentasTerminadas($fechaInicial,$fechaFinal){

            $ventas = self::ctrRangoFechasVentasTerminadas($fechaInicial,$fechaFinal);
            $ventasTerminadas = array();

            if (!is_array($ventas)) {
                return $ventasTerminadas;
            }

            foreach ($ventas as $venta) {

                $cliente = ControladorClientes::ctrMostrarClientes("id", $venta["id_cliente"]);
                $usuario = ControladorUsuarios::ctrMostrarUsuarios("id", $venta["id_vendedor"]);

                $venta["cliente_nombre"] = is_array($cliente) && isset($cliente["nombre"]) ? $cliente["nombre"] : "";
                $venta["vendedor_nombre"] = is_array($usuario) && isset($usuario["nombre"]) ? $usuario["nombre"] : "";

                $ventasTerminadas[] = $venta;
            }

            return $ventasTerminadas;

        }
  
        
    }



?>
