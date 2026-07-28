<?php 

require_once "conexion.php";


class ModeloIngresoegresos{

    
    static public function mdlMostrarHistorialingresosalida($tabla,$item,$valor){

    
        
        //  $stmt3 = Conexion::conectar()->prepare("UPDATE historialcaja SET cliente = (SELECT nombre from clientes where documento=dni) WHERE tipo='PAGOCLIENTE' or tipo='PAGOCLIENTEBANCO'");
        //$stmt3->execute();

    
       
   
          $stmt4 = Conexion::conectar()->prepare("UPDATE historialcaja SET cliente = (SELECT nombre from personas where documento=dni) WHERE tipo='INGRESO CAJA' or tipo='EGRESO CAJA'");
        $stmt4->execute();




        if($item !=null){

            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:$item");

            $stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();
       

        }else{

            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fecha DESC" );

            $stmt->execute();

            return $stmt->fetchAll();

        }



        $stmt->close();
        $stmt=null;

    }
  

    static public function mdlIngresarcajapersona($tabla, $datos){
                
        
		$stmt2 = Conexion::conectar()->prepare("UPDATE caja SET caja = caja + :ingreso2  WHERE estado = 'activo' ");
		
        $stmt=Conexion::conectar()->prepare("INSERT INTO historialcaja(tipo,ingreso,detalleprincipal,detalle,dni,idcliente,nombrecajero,idcaja,estado,fecha) VALUES
        ('INGRESO CAJA',:ingreso,:detalleprincipal,:detalle,:dni,:idcliente,:nombrecajero,(SELECT MAX(id) FROM caja limit 1),:estado,:fecha)");
        
        
        $stmt2->bindParam(":ingreso2", $datos["ingreso"], PDO::PARAM_STR);

        $stmt->bindParam(":ingreso", $datos["ingreso"], PDO::PARAM_STR);
        $stmt->bindParam(":detalleprincipal", $datos["detalleprincipal"], PDO::PARAM_STR);
        $stmt->bindParam(":detalle", $datos["detalle"], PDO::PARAM_STR);
        $stmt->bindParam(":dni", $datos["idcliente"], PDO::PARAM_STR);
        $stmt->bindParam(":idcliente", $datos["idcliente"], PDO::PARAM_STR);
        $stmt->bindParam(":nombrecajero", $datos["nombrecajero"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha" ,date('y-m-d H:i:s'),PDO::PARAM_STR);
        
        $stmt2->execute();
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt->close();
		$stmt = null;
		$stmt2->close();
		$stmt2 = null;

	}




	static public function mdlEgresocajapersona($tabla, $datos){
                
        
		$stmt2 = Conexion::conectar()->prepare("UPDATE caja SET caja =caja - :egreso2 WHERE estado = 'activo' ");
		
        $stmt=Conexion::conectar()->prepare("INSERT INTO historialcaja(
            tipo,salida,detalleprincipal,
            detalle,cliente,dni,idcliente,
            nombrecajero,idcaja,estado,fecha,cerrarpendiente) VALUES

        ('EGRESO CAJA',:egreso,:detalleprincipal,:detalle,
        :cliente,:dni,:idcliente,:nombrecajero,(SELECT MAX(id) FROM caja limit 1),:estado,:fecha,'CIERRE Pendiente')");
        
        
        $stmt2->bindParam(":egreso2", $datos["egreso"], PDO::PARAM_STR);

        $stmt->bindParam(":egreso", $datos["egreso"], PDO::PARAM_STR);
        $stmt->bindParam(":detalleprincipal", $datos["detalleprincipal"], PDO::PARAM_STR);
        $stmt->bindParam(":detalle", $datos["detalle"], PDO::PARAM_STR);
        $stmt->bindParam(":cliente", $datos["idcliente"], PDO::PARAM_STR);
        $stmt->bindParam(":dni", $datos["idcliente"], PDO::PARAM_STR);
        $stmt->bindParam(":idcliente", $datos["idcliente"], PDO::PARAM_STR);
        $stmt->bindParam(":nombrecajero", $datos["nombrecajero"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha" ,date('y-m-d H:i:s'),PDO::PARAM_STR);


		if($stmt2 ->execute() && $stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt->close();
		$stmt = null;
		$stmt2->close();
		$stmt2 = null;

	}

   
   
   
    static public function mdlMostrarIngresoSalidaActualEliminar($tabla,$item,$valor){
        $fechahoy = date('Y-m-d');

   
        $stmt4 = Conexion::conectar()->prepare("UPDATE historialcaja SET cliente = (SELECT nombre from personas where documento=dni) WHERE tipo='INGRESO CAJA' or tipo='EGRESO CAJA'");
        $stmt4->execute();




        if($item !=null){

            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:$item");

            $stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();
       

        }else{

            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE tipo != 'PAGOCLIENTE' and tipo != 'PAGOCLIENTEBANCO' and tipo != 'APERTURA CAJA' and fecha like '%$fechahoy%' ORDER BY fecha DESC;" );

            $stmt->execute();

            return $stmt->fetchAll();

        }



        $stmt->close();
        $stmt=null;

    }

    static public function mdlActualizarIngresoEliminar($valor,$dni,$ingreso,$salida,$fechapago){

        $stmt = Conexion::conectar()->prepare("DELETE FROM historialcaja WHERE id =:id");
		
        $stmt2 = Conexion::conectar()->prepare("UPDATE caja SET caja =caja - :ingreso WHERE estado = 'activo' ");

		$stmt -> bindParam(":id", $valor, PDO::PARAM_STR);

        $stmt2 -> bindParam(":ingreso", $ingreso, PDO::PARAM_STR);

       


        if($stmt -> execute() && $stmt2 -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();
		$stmt = null;
        $stmt2 -> close();
		$stmt2 = null;
     
        


    }

    static public function mdlActualizarEgresoEliminar($valor,$dni,$ingreso,$salida,$fechapago){

        $stmt = Conexion::conectar()->prepare("DELETE FROM historialcaja WHERE id =:id");
            
        $stmt2 = Conexion::conectar()->prepare("UPDATE caja SET caja =caja + :salida WHERE estado = 'activo' ");

        $stmt -> bindParam(":id", $valor, PDO::PARAM_STR);

        $stmt2 -> bindParam(":salida", $salida, PDO::PARAM_STR);

    


        if($stmt -> execute() && $stmt2 -> execute()){

            return "ok";
        
        }else{

            return "error";	

        }

        $stmt -> close();
        $stmt = null;
        $stmt2 -> close();
        $stmt2 = null;
    


    }


  static public function mdlfiltraringresosalida($tabla, $item, $valor, $fecha1, $fecha2)
    {

        $stmt4 = Conexion::conectar()->prepare("UPDATE historialcaja SET cliente = (SELECT nombre from personas where documento=dni) WHERE tipo='INGRESO CAJA' or tipo='EGRESO CAJA'");
        $stmt4->execute();
 
        if ($item != null) {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:$item AND fecha >= :fecha1 AND fecha <= :fecha2");

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->bindParam(":fecha1", $fecha1, PDO::PARAM_STR);
            $stmt->bindParam(":fecha2", $fecha2, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();
        } else {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha >= :fecha1 AND fecha <= :fecha2 ORDER BY fecha DESC");


            $stmt->bindParam(":fecha1", $fecha1, PDO::PARAM_STR);
            $stmt->bindParam(":fecha2", $fecha2, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll();
        }



        $stmt->close();
        $stmt = null;
    }


}


?>