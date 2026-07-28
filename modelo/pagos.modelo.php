<?php 

require_once "conexion.php";


class ModeloPagos{

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


    
    static public function mdl_ver_tabla_excel($tabla)
    {
        $tabla = self::campoSeguro($tabla, array('datos_excel'), 'datos_excel');
        $fechahoy = date('Y-m-d');
    
        try {
            $conn = Conexion::conectar();
            
            
             $observado = $conn->prepare("UPDATE datos_excel d
JOIN historialpagos h
    ON d.dni = h.dni
    AND LOWER(TRIM(d.detalle)) = LOWER(TRIM(h.detalle))
    AND DATE(d.fecha) = DATE(h.fecha)
SET d.observado = 1;
");

$observado->execute();
            
            
            
             $validar = $conn->prepare("UPDATE datos_excel d
JOIN historialpagos h
    ON d.dni = h.dni
    AND DATE(d.fecha) = DATE(h.fecha)
    AND ROUND(d.monto, 1) = ROUND(h.cantidad, 1)
SET d.validado = 1;
");

$validar->execute();
    
            // Use JOIN to perform the update
            $stmtcli = $conn->prepare("
                UPDATE datos_excel
                JOIN clientes
                ON clientes.documento LIKE CONCAT('%', datos_excel.dni, '%')
                SET datos_excel.nombre = clientes.nombre
                WHERE clientes.documento LIKE CONCAT('%', datos_excel.dni, '%')
            ");
    
            $stmtcli->execute();
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    
        try {
            // Fetch data from the specified table
            $stmt = $conn->prepare("SELECT * FROM $tabla WHERE fecha LIKE :fechahoy ORDER BY fecha DESC;");
            $stmt->bindValue(":fechahoy", "%$fechahoy%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll();
            
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    
    
    
     static public function mdlMostrarVentasxcliente($valor)
	{
 		$idCliente = $valor;
	
		// Limpiar los campos totalcompras, totalpagos y saldonuevo
		$stmtLimpiarCampos = Conexion::conectar()->prepare("UPDATE clientes SET total = 0.00, amortizacion = 0.00, saldo = 0.00 WHERE id = :idCliente");
		$stmtLimpiarCampos->bindParam(':idCliente', $idCliente);
		$stmtLimpiarCampos->execute();
	
		// Calcular la suma de ventas
		$stmtTotalVentas = Conexion::conectar()->prepare("SELECT COALESCE(SUM(total), 0.00) AS suma FROM ventas WHERE id_cliente = :idCliente AND estado = 'Terminado'");
		$stmtTotalVentas->bindParam(':idCliente', $idCliente);
		$stmtTotalVentas->execute();
		$sumaVentas = $stmtTotalVentas->fetchColumn();
	
		// Calcular la suma de pagos
		$stmtTotalPagos = Conexion::conectar()->prepare("SELECT COALESCE(SUM(cantidad), 0.00) AS suma FROM historialpagos WHERE idcliente = :idCliente");
		$stmtTotalPagos->bindParam(':idCliente', $idCliente);
		$stmtTotalPagos->execute();
		$sumaPagos = $stmtTotalPagos->fetchColumn();
	
		// Calcular el saldo nuevo
		$saldoNuevo = $sumaVentas - $sumaPagos;
	
		// Actualizar todas las columnas
		$stmtActualizar = Conexion::conectar()->prepare("UPDATE clientes SET total = :total, amortizacion = :amortizacion, saldo = :saldo WHERE id = :idCliente");
		$stmtActualizar->bindParam(':total', $sumaVentas);
		$stmtActualizar->bindParam(':amortizacion', $sumaPagos);
		$stmtActualizar->bindParam(':saldo', $saldoNuevo);
		$stmtActualizar->bindParam(':idCliente', $idCliente);
		$stmtActualizar->execute();
		

		$tablai="clientes";

		$stmt22i = Conexion::conectar()->prepare("UPDATE $tablai SET saldo= total - amortizacion");
  
		$stmt22i->execute();
  

			return "ok";
		

	}

    //ver historial de pagos del cliente 
    static public function mdlMostrarHistorialpagos($tabla,$item,$valor){
        $tabla = self::campoSeguro($tabla, array('historialpagos'), 'historialpagos');
        $item = self::campoOpcional($item, array('id', 'dni', 'idcliente', 'metodopago', 'idvendedor'));
        
        //update ventas set `actual` = (SELECT saldo from clientes where documento = `id_cliente`), `actualvalidar` = 1 where `actualvalidar` != 1
        $stmtvali=Conexion::conectar()->prepare("update ventas set `actual` = (SELECT saldo from clientes where documento = `id_cliente`), `actualvalidar` = 1 where `actualvalidar` != 1");
        $stmtvali->execute();


        $fechahoy = date('Y-m-d');

        if($item !=null){

            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valor");

            $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();
       

        }else{

            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla where fecha like :fechahoy ORDER BY fecha DESC;" );

            $stmt->bindValue(":fechahoy", "%$fechahoy%", PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetchAll();

        }



        $stmt->close();
        $stmt=null;

    }





    
	static public function mdlRegistrarPagosdeClienteefectivo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE clientes SET amortizacion =amortizacion + :nuevaamortizacion WHERE id = :id and 'activo'=(SELECT MAX(estado)FROM caja WHERE estado='activo')");
                
        $stmt2=Conexion::conectar()->prepare("INSERT INTO historialpagos(cantidad,cliente,detalle,dni,idcliente,nombrecajero,metodopago,fecha) VALUES (:nuevaamortizacion,:nombre,:detalle,:documento,:id,:nombrecajero,'PAGOCLIENTE',:fecha) ");   //WHERE id = (SELECT MAX(id) FROM tabla);
        
		$stmt3 = Conexion::conectar()->prepare("UPDATE caja SET caja =caja + :nuevaamortizacion  WHERE estado = 'activo' ");
		
        $stmt4=Conexion::conectar()->prepare("INSERT INTO historialcaja(tipo,ingreso,detalle,cliente,dni,idcliente,nombrecajero,idcaja,fecha) VALUES
         ('PAGOCLIENTE',:nuevaamortizacion ,:detalle,:nombre,:documento,:id,:nombrecajero,(SELECT MAX(id) FROM caja),:fecha)");






		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
	    $stmt->bindParam(":nuevaamortizacion", $datos["nuevaamortizacion"], PDO::PARAM_STR);

        $stmt3->bindParam(":nuevaamortizacion", $datos["nuevaamortizacion"], PDO::PARAM_STR);
		
        
        $stmt4->bindParam(":id", $datos["id"], PDO::PARAM_INT);
        $stmt4->bindParam(":nuevaamortizacion", $datos["nuevaamortizacion"], PDO::PARAM_STR);
        $stmt4->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt4->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
        $stmt4->bindParam(":detalle", $datos["detalle"], PDO::PARAM_STR);
        $stmt4->bindParam(":nombrecajero", $datos["nombrecajero"], PDO::PARAM_STR);
        $stmt4->bindParam(":fecha", date('Y-m-d H:i:s'), PDO::PARAM_STR);


		$stmt2->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		$stmt2->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt2->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
	    $stmt2->bindParam(":detalle", $datos["detalle"], PDO::PARAM_STR);
        $stmt2->bindParam(":nuevaamortizacion", $datos["nuevaamortizacion"], PDO::PARAM_STR);
        $stmt2->bindParam(":nombrecajero", $datos["nombrecajero"], PDO::PARAM_STR);
        $stmt2->bindParam(":fecha",date('Y-m-d H:i:s'), PDO::PARAM_STR);

        //	$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        //	$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        //	$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);

        $stmt->execute();
        $stmt3->execute();
        $stmt4->execute();
        
        
        $stmt6 = Conexion::conectar()->prepare("INSERT INTO ventas
        (id_cliente,id_vendedor,productos,impuesto,neto,total,detalle,estado,pagosclientes,vendedor,fecha,cliente,codigo,saldo) VALUES(
        :id_cliente,:id_vendedor,'0','0','0','0',:detalle,'PAGO CLIENTES',:pagosclientes,:nombrecajero,:fecha,:nombre,'01',:calculofinal)");
        
        

		$stmt6->bindParam(":id_cliente", $datos["documento"], PDO::PARAM_INT);
		$stmt6->bindParam(":id_vendedor", $datos["documento"], PDO::PARAM_STR);
        $stmt6->bindParam(":pagosclientes", $datos["nuevaamortizacion"], PDO::PARAM_STR);
        $stmt6->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt6->bindParam(":calculofinal", $datos["calculofinal"], PDO::PARAM_STR);
        $stmt6->bindParam(":nombrecajero", $datos["nombrecajero"], PDO::PARAM_STR);  
        $stmt6->bindParam(":detalle", $datos["detalle"], PDO::PARAM_STR);
        $stmt6->bindParam(":fecha", date('Y-m-d H:i:s'), PDO::PARAM_STR); //
        $stmt2->execute();

		if($stmt6->execute() ){

			return "ok";

		}else{

			return "error";
		
		}

       



		$stmt->close();
		$stmt = null;
		$stmt2->close();
		$stmt2 = null;
		$stmt3->close();
		$stmt3 = null;
		$stmt4->close();
		$stmt4 = null;
		$stmt6->close();
		$stmt6 = null;

	}

 
    

 
 
    
    static public function mdlRegistrarPagosdeClientebancos($tabla, $datos){
        
        //EDITADO 08
       //$ddd = ModeloPagos::mdlMostrarVentasxcliente($datos["id"]);


		$stmt = Conexion::conectar()->prepare("UPDATE clientes SET amortizacion =amortizacion + :nuevaamortizacion WHERE id = :id and 'activo'=(SELECT MAX(estado)FROM caja WHERE estado='activo')");
                
        $stmt2=Conexion::conectar()->prepare("INSERT INTO historialpagos(cantidad,cliente,detalle,dni,idcliente,nombrecajero,metodopago,fecha) VALUES (:nuevaamortizacion,:nombre,:detalle,:documento,:id,:nombrecajero,'PAGOCLIENTEBANCO',:fecha) ");   //WHERE id = (SELECT MAX(id) FROM tabla);
        
		$stmt3 = Conexion::conectar()->prepare("UPDATE caja SET banco =banco + :nuevaamortizacion  WHERE estado = 'activo' ");
		
        $stmt4=Conexion::conectar()->prepare("INSERT INTO historialcaja(tipo,ingreso,detalle,cliente,dni,idcliente,nombrecajero,idcaja,fecha) VALUES
         ('PAGOCLIENTEBANCO',:nuevaamortizacion ,:detalle,:nombre,:documento,:id,:nombrecajero,(SELECT MAX(id) FROM caja),:fecha)");






		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
	    $stmt->bindParam(":nuevaamortizacion", $datos["nuevaamortizacion"], PDO::PARAM_STR);

        $stmt3->bindParam(":nuevaamortizacion", $datos["nuevaamortizacion"], PDO::PARAM_STR);
		
        
        $stmt4->bindParam(":id", $datos["id"], PDO::PARAM_INT);
        $stmt4->bindParam(":nuevaamortizacion", $datos["nuevaamortizacion"], PDO::PARAM_STR);
        $stmt4->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt4->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
        $stmt4->bindParam(":detalle", $datos["detalle"], PDO::PARAM_STR);
        $stmt4->bindParam(":nombrecajero", $datos["nombrecajero"], PDO::PARAM_STR);
        $stmt4->bindParam(":fecha", date('Y-m-d H:i:s'), PDO::PARAM_STR);


		$stmt2->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		$stmt2->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt2->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
	    $stmt2->bindParam(":detalle", $datos["detalle"], PDO::PARAM_STR);
        $stmt2->bindParam(":nuevaamortizacion", $datos["nuevaamortizacion"], PDO::PARAM_STR);
        $stmt2->bindParam(":nombrecajero", $datos["nombrecajero"], PDO::PARAM_STR);
        $stmt2->bindParam(":fecha",date('Y-m-d H:i:s'), PDO::PARAM_STR);

        //	$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        //	$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        //	$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);

        $stmt->execute();
        $stmt3->execute();
        $stmt4->execute();
        
        
        $stmt6 = Conexion::conectar()->prepare("INSERT INTO ventas
        (id_cliente,id_vendedor,productos,impuesto,neto,total,detalle,estado,pagosclientes,vendedor,fecha,cliente,codigo,saldo) VALUES(
        :id_cliente,:id_vendedor,'0','0','0','0',:detalle,'PAGO CLIENTES BANCO',:pagosclientes,:nombrecajero,:fecha,:nombre,'01',:calculofinal)");
        
        

		$stmt6->bindParam(":id_cliente", $datos["documento"], PDO::PARAM_INT);
		$stmt6->bindParam(":id_vendedor", $datos["documento"], PDO::PARAM_STR);
        $stmt6->bindParam(":pagosclientes", $datos["nuevaamortizacion"], PDO::PARAM_STR);
        $stmt6->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt6->bindParam(":calculofinal", $datos["calculofinal"], PDO::PARAM_STR);
        $stmt6->bindParam(":nombrecajero", $datos["nombrecajero"], PDO::PARAM_STR);  
        $stmt6->bindParam(":detalle", $datos["detalle"], PDO::PARAM_STR);
        $stmt6->bindParam(":fecha", date('Y-m-d H:i:s'), PDO::PARAM_STR); //
        $stmt2->execute();

		if($stmt6->execute() ){

			return "ok";

		}else{

			return "error";
		
		}

       



		$stmt->close();
		$stmt = null;
		$stmt2->close();
		$stmt2 = null;
		$stmt3->close();
		$stmt3 = null;
		$stmt4->close();
		$stmt4 = null;
		$stmt6->close();
		$stmt6 = null;

	}
	
	
	
	
	
	
	
    static public function mdlMostrarHistorialpagosreporte($tabla,$item,$valor){

        $tabla = self::campoSeguro($tabla, array('historialpagos'), 'historialpagos');
        $item = self::campoOpcional($item, array('idcliente', 'dni', 'id', 'metodopago', 'idvendedor'));


        if($item !=null){

            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idcliente = :valor");

            $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetchAll();
       

        }else{

            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fecha DESC");

            $stmt->execute();

            return $stmt->fetchAll();

        }



        $stmt->close();
        $stmt=null;

    }


    static public function mdlMostrarHistorialpagosreporte2($tabla,$item,$valor){

        $tabla = self::campoSeguro($tabla, array('historialpagos'), 'historialpagos');
        $item = self::campoOpcional($item, array('idcliente', 'dni', 'id', 'metodopago', 'idvendedor'));

 $stmtvali=Conexion::conectar()->prepare("update ventas set `actual` = (SELECT saldo from clientes where documento = `id_cliente`), `actualvalidar` = 1 where `actualvalidar` != 1");
        $stmtvali->execute();

        if($item !=null){

            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idcliente = :valor  ORDER BY fecha DESC");

            $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();
       

        }else{

            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fecha ASC " );

            $stmt->execute();

            return $stmt->fetchAll();

        }



        $stmt->close();
        $stmt=null;

    }

    
    //eliminar pagos efectivos
    static public function mdlActualizarClientePagoeliminar($valor,$dnipago,$cantidad,$fechapago,$totalpagocliente){

        $stmt = Conexion::conectar()->prepare("UPDATE clientes SET amortizacion = amortizacion - :cantidad WHERE documento = :dnipago");
        $stmt2 = Conexion::conectar()->prepare("DELETE FROM historialpagos WHERE id=:id");
        $stmt3 = Conexion::conectar()->prepare("DELETE FROM historialcaja WHERE dni = :dnipago3 and ingreso =:totalpagocliente and fecha=:fechapago3");
		$stmt4 = Conexion::conectar()->prepare("UPDATE caja SET caja =caja - :totalpagocliente4 WHERE estado = 'activo' ");
        $stmt5 = Conexion::conectar()->prepare("DELETE FROM ventas WHERE id_cliente = :dnipago5 and pagosclientes =:totalpagocliente5 and fecha=:fechapago5");

		$stmt -> bindParam(":dnipago", $dnipago, PDO::PARAM_STR);
		$stmt -> bindParam(":cantidad", $cantidad, PDO::PARAM_STR);
		$stmt2 -> bindParam(":id", $valor, PDO::PARAM_STR);

        $stmt3 -> bindParam(":dnipago3", $dnipago, PDO::PARAM_STR);
		$stmt3 -> bindParam(":totalpagocliente", $totalpagocliente, PDO::PARAM_STR);
		$stmt3 -> bindParam(":fechapago3", $fechapago, PDO::PARAM_STR);
		
		$stmt4 -> bindParam(":totalpagocliente4", $totalpagocliente, PDO::PARAM_STR);

        $stmt5 -> bindParam(":dnipago5", $dnipago, PDO::PARAM_STR);
		$stmt5 -> bindParam(":totalpagocliente5", $totalpagocliente, PDO::PARAM_STR);
		$stmt5 -> bindParam(":fechapago5", $fechapago, PDO::PARAM_STR);


        $stmt -> execute();
        $stmt2 -> execute();
        $stmt3 -> execute();
        $stmt4 -> execute();

        if($stmt5 -> execute()){

			return "ok";
		
		}else{

			return "error";	

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
    
    
    
    //eliminar pagos de los bancos 
    static public function mdlActualizarClientePagoeliminarbanco($valor,$dnipago,$cantidad,$fechapago,$totalpagocliente){

    $stmt = Conexion::conectar()->prepare("UPDATE clientes SET amortizacion = amortizacion - :cantidad WHERE documento = :dnipago");
    $stmt2 = Conexion::conectar()->prepare("DELETE FROM historialpagos WHERE id=:id");
    $stmt3 = Conexion::conectar()->prepare("DELETE FROM historialcaja WHERE dni = :dnipago3 and ingreso =:totalpagocliente and fecha=:fechapago3");
    $stmt4 = Conexion::conectar()->prepare("UPDATE caja SET banco =banco - :totalpagocliente4 WHERE estado = 'activo' ");
    $stmt5 = Conexion::conectar()->prepare("DELETE FROM ventas WHERE id_cliente = :dnipago5 and pagosclientes =:totalpagocliente5 and fecha=:fechapago5");

    $stmt -> bindParam(":dnipago", $dnipago, PDO::PARAM_STR);
    $stmt -> bindParam(":cantidad", $cantidad, PDO::PARAM_STR);
    $stmt2 -> bindParam(":id", $valor, PDO::PARAM_STR);

    $stmt3 -> bindParam(":dnipago3", $dnipago, PDO::PARAM_STR);
    $stmt3 -> bindParam(":totalpagocliente", $totalpagocliente, PDO::PARAM_STR);
    $stmt3 -> bindParam(":fechapago3", $fechapago, PDO::PARAM_STR);

    $stmt4 -> bindParam(":totalpagocliente4", $totalpagocliente, PDO::PARAM_STR);

    $stmt5 -> bindParam(":dnipago5", $dnipago, PDO::PARAM_STR);
    $stmt5 -> bindParam(":totalpagocliente5", $totalpagocliente, PDO::PARAM_STR);
    $stmt5 -> bindParam(":fechapago5", $fechapago, PDO::PARAM_STR);

    if($stmt -> execute() && $stmt2 -> execute() && $stmt3 -> execute() && $stmt4 -> execute() && $stmt5 -> execute()){

        return "ok";
    
    }else{

        return "error";	

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
