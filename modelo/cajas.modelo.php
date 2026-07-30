<?php 

    require_once "conexion.php";

class ModeloCajas{

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
        
        
        
        
        
        
        
    // Método para seleccionar los registros con 'cerrarpendiente' mayor a 0 y 'relacionado' igual a 0
    static public function mdlObtenerCerrarPendiente()
    {
        $stmt = Conexion::conectar()->prepare("SELECT id AS ID_INICIO,
            cerrarpendiente, detalleprincipal 
            FROM historialcaja 
            WHERE cerrarpendiente > 0 
            AND relacionar = 0
        ");

        // Ejecutar la consulta
        $stmt->execute();

        // Devolver los resultados
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para actualizar el detalleprincipal y el campo 'relacionado'
    static public function mdlActualizarDetallePrincipal()
    {
        // Obtener los registros con 'cerrarpendiente' mayor a 0 y 'relacionado' igual a 0
        $registros = ModeloCajas::mdlObtenerCerrarPendiente();

        // Verificar si hay registros con 'cerrarpendiente' mayor a 0
        if (count($registros) > 0) {
            foreach ($registros as $registro) {
                // Obtener el ID del registro que corresponde al 'cerrarpendiente'
                $cerrarpendienteId = $registro['cerrarpendiente'];
                $ID_INICIO = $registro['ID_INICIO'];

                // 1. Actualizamos el campo 'detalleprincipal' con el ID del registro al que hace referencia 'cerrarpendiente'
                $stmt = Conexion::conectar()->prepare("
                    UPDATE historialcaja 
                    SET detalleprincipal = CONCAT(detalleprincipal, ' TICKET',:ID_INICIO) 
                    WHERE id = :cerrarpendienteId
                ");

                // Bind de los parámetros
                $stmt->bindParam(":ID_INICIO", $ID_INICIO, PDO::PARAM_STR);
                $stmt->bindParam(":cerrarpendienteId", $cerrarpendienteId, PDO::PARAM_STR);

                // Ejecutar la consulta de actualización
                $stmt->execute();

                // 2. Ahora, marcamos el campo 'relacionado' del registro con el ID igual al 'cerrarpendiente' como 1
                $stmt2 = Conexion::conectar()->prepare("
                    UPDATE historialcaja 
                    SET relacionar = 1 
                    WHERE ID = :ID_INICIO
                ");

                // Bind del parámetro
                $stmt2->bindParam(":ID_INICIO", $ID_INICIO, PDO::PARAM_INT);

                // Ejecutar la consulta de actualización
                $stmt2->execute();
            }

            // Si todo ha ido bien, devolvemos 'ok'
            return "ok";
        } else {
            // Si no hay registros para actualizar, devolvemos 'error'
            return "error";
        }
    }







        //MOSTRAR TODAS LAS CAJAS
        static public function mdlMostrarCajas($tabla,$item,$valor){

            $tabla = self::campoSeguro($tabla, array('caja'), 'caja');
            $item = self::campoOpcional($item, array('id', 'estado', 'cajero', 'idcaja', 'fecha'));
        

            if($item !=null){

                $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valor");

                $stmt->bindParam(":valor", $valor,PDO::PARAM_STR);

                $stmt->execute();

                return $stmt->fetch();

            }else{

            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fecha DESC; ");

            $stmt->execute();

            return $stmt->fetchAll();

            }


        $stmt->close();
            $stmt=null;


        }


        //MOSTRAR MONTO DE LA CAJA ULTIMA
        static public function mdlMostrarCajasmonto($tabla,$item,$valor){

            $tabla = self::campoSeguro($tabla, array('caja'), 'caja');

            if($item !=null){
                $stmt=Conexion::conectar()->prepare("SELECT * FROM caja order by id desc limit 1");

             //2424   $stmt->bindParam(":".$item ,$valor,PDO::PARAM_STR);

                $stmt->execute();

                return $stmt->fetch();

            }else{

        
            }
        }


        //CREAR CAJA NUEVO
        static public function mdlIngresarCajas($tabla,$datos){


            $consulta = Conexion::conectar()->prepare("SELECT COUNT(*) as total FROM caja WHERE estado = 'activo'");
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        
            if ($resultado['total'] == 0) {
        
                $stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(caja,estado,detallecaja,cajero,fecha) VALUES (:caja,'activo',:detallecaja,:cajero,:fecha)");
                //$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(caja,estado) VALUES (:caja,'activo')");
    
                $stmt2=Conexion::conectar()->prepare("INSERT INTO historialcaja(tipo,ingreso,detalleprincipal,detalle,cliente,dni,idcliente,nombrecajero,idcaja,estado,fecha) VALUES
                ('APERTURA CAJA',:caja,'APERTURA',:detallecaja,'99','99','99',:cajero,(SELECT MAX(id) FROM caja limit 1),'APERTURA',:fecha)");
    
                $stmt->bindParam(":caja" ,$datos["caja"],PDO::PARAM_STR);
                $stmt->bindParam(":detallecaja" ,$datos["detallecaja"],PDO::PARAM_STR);
                $stmt->bindParam(":cajero" ,$datos["cajero"],PDO::PARAM_STR);        
                $stmt->bindParam(":fecha" ,date('y-m-d H:i:s'),PDO::PARAM_STR);
    
    
                $stmt2->bindParam(":caja" ,$datos["caja"],PDO::PARAM_STR);
                $stmt2->bindParam(":detallecaja" ,$datos["detallecaja"],PDO::PARAM_STR);
                $stmt2->bindParam(":cajero" ,$datos["cajero"],PDO::PARAM_STR);
                $stmt2->bindParam(":fecha" ,date('y-m-d H:i:s'),PDO::PARAM_STR);
    
                if($stmt->execute() && $stmt2->execute()){
    
                    return "ok";
    
                }else{
    
                    return "error";
    
                }

                $stmt->close();
                $stmt=null;
                $stmt2->close();
                $stmt2=null;
            }else{
                return "activo";
            }

        }


        //cerrar caja 
        static public function mdlActualizarCajascierre($tabla, $item1, $valor1, $item2, $valor2){

            $tabla = self::campoSeguro($tabla, array('caja'), 'caja');
            $item1 = self::campoOpcional($item1, array('estado', 'fechacierre', 'caja', 'banco'));
            $item2 = self::campoOpcional($item2, array('id', 'estado', 'cajero'));
    
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :valor1 ,fechacierre = :fecha WHERE $item2 = :valor2");

            $stmt -> bindParam(":valor1", $valor1, PDO::PARAM_STR);
            $stmt -> bindParam(":valor2", $valor2, PDO::PARAM_STR);
            $stmt ->bindParam(":fecha" ,date('y-m-d H:i:s'),PDO::PARAM_STR);
    
    
    
            if($stmt -> execute() ){
    
                return "ok";
            
            }else{
    
                return "error";	
    
            }
    
            $stmt -> close();
    
            $stmt = null;
    
    
    
    
        }
    

        //HISTORIAL PARA CAJA REPORTE PDF
        static public function mdlMostrarHistorialcajas($tabla,$item,$valor){

            $tabla = self::campoSeguro($tabla, array('historialcaja'), 'historialcaja');
            $item = self::campoOpcional($item, array('idcaja', 'id', 'dni', 'idcliente'));


            if($item !=null){

                $stmt=Conexion::conectar()->prepare("SELECT * FROM historialcaja WHERE idcaja = :valor ");

                $stmt->bindParam(":valor", $valor,PDO::PARAM_STR);

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
        
        static public function mdlMostrarHistorialcajas7fe($tabla,$item,$valor){

            $tabla = self::campoSeguro($tabla, array('historialcaja'), 'historialcaja');
            $item = self::campoOpcional($item, array('idcaja', 'id', 'dni', 'idcliente'));


            if($item !=null){

                $stmt=Conexion::conectar()->prepare("SELECT * FROM historialcaja WHERE idcaja = :valor AND TIPO NOT LIKE '%BANCO%' ");

                $stmt->bindParam(":valor", $valor,PDO::PARAM_STR);

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

        //HISTORIAL PARA CAJA REPORTE PDF
        static public function mdlMostrarHistorialcajas2($tabla,$item,$valor){

            $tabla = self::campoSeguro($tabla, array('historialcaja', 'caja'), 'caja');
            $item = self::campoOpcional($item, array('id', 'idcaja', 'dni', 'idcliente'));


            if($item !=null){

                $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id = :valor");

                $stmt->bindParam(":valor", $valor,PDO::PARAM_STR);

                $stmt->execute();

                return $stmt->fetch();
        

            }else{

                $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC " );

                $stmt->execute();

                return $stmt->fetchAll();

            }



            $stmt->close();
            $stmt=null;

        }
        
        
        static public function mdlIngresEgrescajas($item, $valor)
        {
    
$stmt = Conexion::conectar()->prepare("
    SELECT 
        SUM(CASE 
            WHEN tipo LIKE '%APERTURA%' OR tipo = 'PAGOCLIENTE' OR tipo = 'INGRESO CAJA' OR tipo LIKE '%INGRESO CAJA PENDIENTE%' AND tipo != 'PAGOCLIENTEBANCO'
            THEN ingreso 
            ELSE 0 
        END) AS suma_ingreso_caja, 
        SUM(CASE 
            WHEN tipo LIKE '%EGRESO CAJA%' 
            THEN salida 
            ELSE 0 
        END) AS suma_egreso_caja 
    FROM historialcaja 
    WHERE idcaja = :add
");

            $stmt->bindParam(":add", $valor, PDO::PARAM_STR);
    
            $stmt->execute();
            return $stmt->fetch();
    
    
            $stmt->close();
            $stmt = null;
        }

    }


?>
