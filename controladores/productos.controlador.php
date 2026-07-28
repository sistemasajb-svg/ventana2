<?php

    class ControladorProductos{


 
	 

 

		static public function ctrMostrarProductos($item,$valor,$orden){

			$tabla = "productos";
	
			$orden="ventas";
	
			$respuesta=ModeloProductos::mdlMostrarProductos($tabla,$item,$valor,$orden);
	
			return $respuesta;
	
	
		}
	

		

        
    }



?>