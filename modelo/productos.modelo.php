<?php 

require_once "conexion.php";


class ModeloProductos{


    static public function mdlMostrarProductos($tabla, $item,$valor,$orden){


		
        if($item !=null){
		    $stmt2 = Conexion::conectar()->prepare("UPDATE $tabla SET totaljabas =TRUNCATE(stock /'360',0), celdaconvertir =stock - (totaljabas * '360')");
			$stmt3 = Conexion::conectar()->prepare("UPDATE $tabla SET totalcelda =celdaconvertir / '20' WHERE descripcion = 'Jumbo'");
			$stmt4 = Conexion::conectar()->prepare("UPDATE $tabla SET totalcelda =celdaconvertir / '30' WHERE descripcion != 'Jumbo'");
			$stmt5 = Conexion::conectar()->prepare("DELETE FROM movimientos WHERE tipo ='INGRESO PRODUCTO' and cantidad='0'");


            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");

            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();
			$stmt2 -> execute();
			$stmt3 -> execute();
			$stmt4 -> execute();
			$stmt5 -> execute();
			
			return $stmt -> fetch();

        }else{
			$stmt2 = Conexion::conectar()->prepare("UPDATE $tabla SET totaljabas =TRUNCATE(stock /'360',0), celdaconvertir =stock - (totaljabas * '360')");
			$stmt3 = Conexion::conectar()->prepare("UPDATE $tabla SET totalcelda =celdaconvertir / '20' WHERE descripcion = 'Jumbo'");
			$stmt4 = Conexion::conectar()->prepare("UPDATE $tabla SET totalcelda =celdaconvertir / '30' WHERE descripcion != 'Jumbo'");
			$stmt5 = Conexion::conectar()->prepare("DELETE FROM movimientos WHERE tipo ='INGRESO PRODUCTO' and cantidad='0'");

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $orden DESC");

             $stmt -> execute();
            $stmt2 -> execute();
            $stmt3 -> execute();
            $stmt4 -> execute();
	        $stmt5 -> execute();

			return $stmt -> fetchAll();

        }

        $stmt -> close();
		$stmt = null;
		
		$stmt2 -> close();
		$stmt2 = null;
		
		$stmt3 -> close();
		$stmt3 = null;
		
		$stmt4 -> close();
		$stmt4 = null;


	    $stmt5 -> close();
		$stmt5 = null;


    }
	

 


}


?>