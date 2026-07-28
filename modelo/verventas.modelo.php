<?php 

require_once "conexion.php";


class ModeloVerventas{
    
    
    static public function mdlVentasporfecha($tabla, $fechaInicial, $fechaFinal)
	{
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha >= '$fechaInicial' AND fecha <= '$fechaFinal'; ");

		$stmt->bindParam(":fecha1", $fechaInicial, PDO::PARAM_STR);
		$stmt->bindParam(":fecha2", $fechaFinal, PDO::PARAM_STR);

		$stmt->execute();

		return $stmt->fetchAll();
	}
    
    


    static public function mdlRangoFechasVentasTerminadas($tabla,$fechaInicial,$fechaFinal){



		if($fechaInicial == null){
	
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado like 'Terminado' ORDER BY codigo DESC LIMIT 100");
	
			$stmt -> execute();
	
			return $stmt -> fetchAll();	
	
	
	
		}else if($fechaInicial ==$fechaFinal){
	
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%' and estado like 'Terminado' ORDER BY id_cliente DESC");
	
				$stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);
	
				$stmt -> execute();
	
				return $stmt -> fetchAll();
	
	
	
		}else{
	
	
			$fechaFinal=explode("-",$fechaFinal);
	
			//var_dump($fechaFinal);
	
			$fechaFinal =$fechaFinal[0].'-'.$fechaFinal[1].'-'.($fechaFinal[2]+1);
	
			if($fechaInicial != $fechaFinal){
	
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' and '$fechaFinal' and estado like 'Terminado' ORDER BY id_cliente DESC");
	
	
	
	
			}
	
			$stmt -> execute();
	
			return $stmt -> fetchAll();
	
	
	
		}
	
	
	
	
	
	}

    static public function mdlMostrarVentas($tabla,$item,$valor){

        if($item !=null){

            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE $item=:$item and codigo > '999' ORDER BY id ASC");

            $stmt ->bindParam(":".$item ,$valor,PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();



        }else{

            $stmt=Conexion::conectar()->prepare("SELECT * FROM  $tabla WHERE codigo > '999' ORDER BY id ASC");

            $stmt->execute();

            return $stmt->fetchAll();

        }

        $stmt->close();
        $stmt=null;

    }

 


}


?>