<?php 

require_once "conexion.php";


class ModeloPendientes{

    static private function campoSeguro($campo, $permitidos, $default)
    {
        return in_array($campo, $permitidos, true) ? $campo : $default;
    }

    static private function campoOpcional($campo, $permitidos)
    {
        if ($campo === null) {
            return null;
        }

        return in_array($campo, $permitidos, true) ? $campo : null;
    }

    static public function mdlMostrarPendientes($tabla,$item,$valor){

        $tabla = self::campoSeguro($tabla, array('pendientes'), 'pendientes');
        $item = self::campoOpcional($item, array('id', 'documento', 'email', 'telefono', 'estado'));


        if($item !=null){

            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valor");

            $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();
       

        }else{

            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado like 'ingresoenproceso' or estado like 'salidaenproceso' or estado like 'enProceso' ");

            $stmt->execute();

            return $stmt->fetchAll();

        }



        $stmt->close();
        $stmt=null;

    }


                        
    static public function mdlIngresarPendiente($tabla,$datos){

        $tabla = self::campoSeguro($tabla, array('pendientes'), 'pendientes');

        $stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(nombre,documento,email,telefono,direccion,fecha_nacimiento) VALUES (:nombre,:documento,:email,:telefono,:direccion,:fecha_nacimiento)");

        $stmt->bindParam(":nombre",$datos["nombre"] ,PDO::PARAM_STR);
        $stmt->bindParam(":documento",$datos["documento"] ,PDO::PARAM_STR);
        $stmt->bindParam(":email",$datos["email"] ,PDO::PARAM_STR);
        $stmt->bindParam(":telefono",$datos["telefono"] ,PDO::PARAM_STR);
        $stmt->bindParam(":direccion",$datos["direccion"] ,PDO::PARAM_STR);
        $stmt->bindParam(":fecha_nacimiento",$datos["fecha_nacimiento"] ,PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";


        }else{

            return "error";
        }
         $stmt->close();
        $stmt=null;


    }





static public function mdlEditarPendienteegreso($tabla, $datos){

		$tabla = self::campoSeguro($tabla, array('pendientes'), 'pendientes');

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET detalle = :editardetallesegundo, estado = :estadopendientes, cerrarpendiente = 'CERRADO' WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":editardetallesegundo", $datos["editardetallesegundo"], PDO::PARAM_STR);
        $stmt->bindParam(":estadopendientes", $datos["estadopendientes"], PDO::PARAM_STR);


        //  AGREWGAR
        $stmt3 = Conexion::conectar()->prepare("UPDATE caja SET caja =caja - :nuevototalcaja  WHERE estado = 'activo' ");
		
        $stmt4=Conexion::conectar()->prepare("INSERT INTO historialcaja(tipo,salida,detalleprincipal,detalle,cliente,dni,idcliente,nombrecajero,idcaja,estado,fecha,cerrarpendiente) VALUES
        ('EGRESO CAJA PENDIENTE',:ingreso,:detalleprincipal,:detalle,:cliente,:dni,:idcliente,:nombrecajero,(SELECT MAX(id) FROM caja limit 1),:estado,:fecha,:cerrarpendiente)");

        $stmt4->bindParam(":ingreso", $datos["ingreso"], PDO::PARAM_STR);
        $stmt4->bindParam(":detalleprincipal", $datos["detalleprincipal"], PDO::PARAM_STR);
        $stmt4->bindParam(":detalle", $datos["detalle"], PDO::PARAM_STR);
        $stmt4->bindParam(":dni", $datos["dnicliente"], PDO::PARAM_STR);
        $stmt4->bindParam(":idcliente", $datos["dnicliente"], PDO::PARAM_STR);
        $stmt4->bindParam(":cliente", $datos["nombrecliente"], PDO::PARAM_STR);
        $stmt4->bindParam(":nombrecajero", $datos["nombrecajero"], PDO::PARAM_STR);
        $stmt4->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt4->bindParam(":cerrarpendiente", $datos["id"], PDO::PARAM_STR);
        $stmt4->bindParam(":fecha" ,date('y-m-d H:i:s'),PDO::PARAM_STR);

        $stmt3->bindParam(":nuevototalcaja", $datos["nuevototalcaja"], PDO::PARAM_STR);

		if($stmt->execute() && $stmt3->execute() && $stmt4->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;
		$stmt3->close();
		$stmt3 = null;
		$stmt4->close();
		$stmt4 = null;

	}




    static public function mdlEditarPendiente($tabla, $datos){

		$tabla = self::campoSeguro($tabla, array('pendientes'), 'pendientes');

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET detalle = :editardetallesegundo, estado = :estadopendientes, cerrarpendiente = 'CERRADO' WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":editardetallesegundo", $datos["editardetallesegundo"], PDO::PARAM_STR);
        $stmt->bindParam(":estadopendientes", $datos["estadopendientes"], PDO::PARAM_STR);


        //  AGREWGAR
        $stmt3 = Conexion::conectar()->prepare("UPDATE caja SET caja =caja + :nuevototalcaja  WHERE estado = 'activo' ");
		
        $stmt4=Conexion::conectar()->prepare("INSERT INTO historialcaja(tipo,ingreso,detalleprincipal,detalle,cliente,dni,idcliente,nombrecajero,idcaja,estado,fecha,cerrarpendiente) VALUES
        ('INGRESO CAJA PENDIENTE',:ingreso,:detalleprincipal,:detalle,:cliente,:dni,:idcliente,:nombrecajero,(SELECT MAX(id) FROM caja limit 1),:estado,:fecha,:cerrarpendiente)");

        $stmt4->bindParam(":ingreso", $datos["ingreso"], PDO::PARAM_STR);
        $stmt4->bindParam(":detalleprincipal", $datos["detalleprincipal"], PDO::PARAM_STR);
        $stmt4->bindParam(":detalle", $datos["detalle"], PDO::PARAM_STR);
        $stmt4->bindParam(":dni", $datos["dnicliente"], PDO::PARAM_STR);
        $stmt4->bindParam(":idcliente", $datos["dnicliente"], PDO::PARAM_STR);
        $stmt4->bindParam(":cliente", $datos["nombrecliente"], PDO::PARAM_STR);
        $stmt4->bindParam(":nombrecajero", $datos["nombrecajero"], PDO::PARAM_STR);
        $stmt4->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt4->bindParam(":cerrarpendiente", $datos["id"], PDO::PARAM_STR);
        $stmt4->bindParam(":fecha" ,date('y-m-d H:i:s'),PDO::PARAM_STR);

        $stmt3->bindParam(":nuevototalcaja", $datos["nuevototalcaja"], PDO::PARAM_STR);

		if($stmt->execute() && $stmt3->execute() && $stmt4->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;
		$stmt3->close();
		$stmt3 = null;
		$stmt4->close();
		$stmt4 = null;

	}


    static public function mdlEliminarPendiente($tabla, $datos){

        $tabla = self::campoSeguro($tabla, array('pendientes'), 'pendientes');

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id=:id");

        $stmt->bindParam(":id", $datos, PDO::PARAM_INT);

        if($stmt->execute()){

            return "ok";
        }else{

            return "error";
        }

        	$stmt->close();
		$stmt = null;






    }

	/*=============================================
	ACTUALIZAR CLIENTE
	=============================================*/

    static public function mdlActualizarPendiente($tabla, $item1, $valor1, $valor){

		$tabla = self::campoSeguro($tabla, array('pendientes'), 'pendientes');
        $item1 = self::campoOpcional($item1, array('detalle', 'estado', 'cerrarpendiente', 'documento'));

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :valor1 WHERE id = :id");

		$stmt -> bindParam(":valor1", $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":id", $valor, PDO::PARAM_STR);

        if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;




    }


}


?>
