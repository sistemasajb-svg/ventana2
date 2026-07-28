<?php

require_once "conexion.php";

class ModeloPagoMasivo
{
    static public function mdlxxxxxxxxxxxcodigomasivo($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY idmasiva DESC LIMIT 1");
        $stmt->execute();
        $codigo = $stmt->fetch();
        $codi =  $codigo["idmasiva"] + 1;
        return $codi;
        $stmt = null;
    }
    
    
    
      static public function mdlcodigomasivo($tabla)
    {
        // Obtener la fecha actual en formato MySQL (YYYY-MM-DD)
        $fecha_actual = date("Y-m-d");

        // Consulta para obtener el mayor idmasiva para la fecha actual
        $stmt = Conexion::conectar()->prepare("SELECT MAX(idmasiva) AS idmasiva FROM $tabla WHERE  DATE(fecha) = :fecha_actual");
        $stmt->bindParam(":fecha_actual", $fecha_actual, PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si hay registros para la fecha actual, usar el siguiente idmasiva
        if ($resultado['idmasiva'] !== null) {
            $codi = $resultado['idmasiva'];
        } else {
            // Si no hay registros para la fecha actual, obtener el mayor idmasiva de todas las fechas
            $stmt = Conexion::conectar()->prepare("SELECT MAX(idmasiva) AS idmasiva FROM $tabla");
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            // Si hay registros en la tabla, sumarle 1 al mayor idmasiva encontrado
            if ($resultado['idmasiva'] !== null) {
                $codi = $resultado['idmasiva'] + 1;
            } else {
                // Si no hay registros en la tabla, iniciar en 1
                $codi = 1;
            }
        }

        return $codi;
    }
    
    
    
    
    
    

    static public function mdlMostrarPersonas($tabla, $item, $valor)
    {
        $tabla = $tabla === 'personas' ? 'personas' : 'personas';
        $item = in_array($item, array('id', 'documento', 'nombre', 'email', 'telefono'), true) ? $item : null;

        if ($item === null) {
            return null;
        }

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valor");
        $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch();



        $stmt = null;
    }




    static public function bk27mdlMostrarClientesTrabajador($tabla)
    {

        $stmtvali = Conexion::conectar()->prepare("update ventas set `actual` = (SELECT saldo from clientes where documento = ventas.`id_cliente`), `actualvalidar` = '1' where `actualvalidar` != '1'");
        $stmtvali->execute();

        $stmt3 = Conexion::conectar()->prepare("UPDATE clientes SET saldo=total - amortizacion");
        $stmt3->execute();

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where tipo = 'Trabajador'");
        $stmt->execute();

        return $stmt->fetchAll();

        $stmt = null;

     }
     
     
     
     
     static public function mdlMostrarClientesTrabajador($tabla)
    {

        $stmtvali = Conexion::conectar()->prepare("update ventas set `actual` = (SELECT saldo from clientes where documento = ventas.`id_cliente`), `actualvalidar` = '1' where `actualvalidar` != '1'");
        $stmtvali->execute();


        // Obtener todos los clientes tipo "Trabajador"
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE tipo = 'Trabajador'");
        $stmt->execute();

        // Obtener los resultados
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Revalidar cálculos para cada cliente
        foreach ($clientes as $cliente) {
            $idCliente = $cliente['id'];

            // Llamar a la función de revalidación por cada cliente
            self::mdlRevalidarCalcularVentaYpagos($idCliente);
            
          //  $ddd = ModeloPagos::mdlMostrarVentasxcliente($idCliente);

        }

        // Volver a consultar para obtener los datos actualizados
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE tipo = 'Trabajador'");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    static public function mdlRevalidarCalcularVentaYpagos($valor)
    {
        $idCliente = $valor;

        // Validar el ID del cliente
        if (!filter_var($idCliente, FILTER_VALIDATE_INT)) {
            throw new InvalidArgumentException("ID del cliente no válido.");
        }

        $db = Conexion::conectar(); // Conexión reutilizable

        try {
            // Iniciar transacción
            $db->beginTransaction();

            // Bloquear el registro del cliente
            $stmtBloquearCliente = $db->prepare("SELECT total, amortizacion, saldo FROM clientes WHERE id = :idCliente FOR UPDATE");
            $stmtBloquearCliente->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
            $stmtBloquearCliente->execute();

            // Limpiar los campos
            $stmtLimpiarCampos = $db->prepare("UPDATE clientes SET total = 0.00, amortizacion = 0.00, saldo = 0.00 WHERE id = :idCliente");
            $stmtLimpiarCampos->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
            $stmtLimpiarCampos->execute();

            // Calcular sumas
            $stmtTotalVentas = $db->prepare("SELECT COALESCE(SUM(total), 0.00) AS suma FROM ventas WHERE id_cliente = :idCliente AND estado = 'Terminado'");
            $stmtTotalVentas->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
            $stmtTotalVentas->execute();
            $sumaVentas = (float) $stmtTotalVentas->fetchColumn();

            $stmtTotalPagos = $db->prepare("SELECT COALESCE(SUM(cantidad), 0.00) AS suma FROM historialpagos WHERE idcliente = :idCliente");
            $stmtTotalPagos->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
            $stmtTotalPagos->execute();
            $sumaPagos = (float) $stmtTotalPagos->fetchColumn();

            // Calcular el saldo
            $saldoNuevo = $sumaVentas - $sumaPagos;

            // Actualizar cliente
            $stmtActualizar = $db->prepare("UPDATE clientes SET total = :total, amortizacion = :amortizacion, saldo = :saldo WHERE id = :idCliente");
            $stmtActualizar->bindParam(':total', $sumaVentas, PDO::PARAM_STR);
            $stmtActualizar->bindParam(':amortizacion', $sumaPagos, PDO::PARAM_STR);
            $stmtActualizar->bindParam(':saldo', $saldoNuevo, PDO::PARAM_STR);
            $stmtActualizar->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
            $stmtActualizar->execute();

            // Confirmar transacción
            $db->commit();
        } catch (PDOException $e) {
            // Revertir cambios
            $db->rollBack();

            // Loguear error
            error_log("Error al procesar ID Cliente {$idCliente}: " . $e->getMessage());

            // Re-lanzar excepción
            throw new Exception("Error al procesar la solicitud: " . $e->getMessage());
        } finally {
            // Liberar recursos
            $db = null;
            $stmtBloquearCliente = null;
            $stmtLimpiarCampos = null;
            $stmtTotalVentas = null;
            $stmtTotalPagos = null;
            $stmtActualizar = null;
        }
    }
     
     
     
     
     
     
     
     
     
}
