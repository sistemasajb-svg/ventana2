<?php 

require_once "conexion.php";


class ModeloVerventas{
    
    
    static public function mdlVentasporfecha($tabla, $fechaInicial, $fechaFinal)
	{
		$db = Conexion::conectar();
		$stmt = $db->prepare("SELECT * FROM $tabla WHERE fecha >= :fechaInicial AND fecha < :fechaFinal");
		$fechaFinalConsulta = date('Y-m-d', strtotime($fechaFinal . ' +1 day'));

		$stmt->bindParam(":fechaInicial", $fechaInicial, PDO::PARAM_STR);
		$stmt->bindParam(":fechaFinal", $fechaFinalConsulta, PDO::PARAM_STR);

		$stmt->execute();

		$resultado = $stmt->fetchAll();
		$stmt->closeCursor();

		return $resultado;
	}
    
    


    static public function mdlRangoFechasVentasTerminadas($tabla,$fechaInicial,$fechaFinal){

		$db = Conexion::conectar();



		if($fechaInicial == null){
	
			$stmt = $db->prepare("SELECT * FROM $tabla WHERE estado like 'Terminado' ORDER BY codigo DESC LIMIT 100");
	
			$stmt -> execute();
	
			$resultado = $stmt->fetchAll();
			$stmt->closeCursor();

			return $resultado;	
	
	
	
		}else if($fechaInicial ==$fechaFinal){
	
				$stmt = $db->prepare("SELECT * FROM $tabla WHERE fecha >= :fechaInicial AND fecha < :fechaFinal and estado like 'Terminado' ORDER BY id_cliente DESC");
				$fechaFinalConsulta = date('Y-m-d', strtotime($fechaFinal . ' +1 day'));

				$stmt -> bindParam(":fechaInicial", $fechaInicial, PDO::PARAM_STR);
				$stmt -> bindParam(":fechaFinal", $fechaFinalConsulta, PDO::PARAM_STR);
	
				$stmt -> execute();
	
				$resultado = $stmt->fetchAll();
				$stmt->closeCursor();

				return $resultado;
	
	
	
		}else{
	
	
			$fechaFinalConsulta = date('Y-m-d', strtotime($fechaFinal . ' +1 day'));
			$stmt = $db->prepare("SELECT * FROM $tabla WHERE fecha >= :fechaInicial AND fecha < :fechaFinal and estado like 'Terminado' ORDER BY id_cliente DESC");
			$stmt->bindParam(":fechaInicial", $fechaInicial, PDO::PARAM_STR);
			$stmt->bindParam(":fechaFinal", $fechaFinalConsulta, PDO::PARAM_STR);
			
			$stmt -> execute();
	
			$resultado = $stmt->fetchAll();
			$stmt->closeCursor();

			return $resultado;
	
	
	
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
