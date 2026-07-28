<?php

session_start();
date_default_timezone_set('America/Lima');

require 'vendor/autoload.php';
require_once __DIR__ . "/modelo/conexion.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

$conn = Conexion::conectar();
$cajero = $_SESSION["nombre"];
$idvendedor = $_SESSION["id"];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $spreadsheet = IOFactory::load($fileTmpPath);
    $sheet = $spreadsheet->getActiveSheet();
    $highestRow = $sheet->getHighestRow();

    try {
        $conn->beginTransaction();

        for ($row = 2; $row <= $highestRow; $row++) {
            $dni = $sheet->getCell('A' . $row)->getValue();
            $monto = $sheet->getCell('B' . $row)->getValue();
            $detalle = $sheet->getCell('C' . $row)->getValue();

            if (!is_numeric($monto) || $monto <= 0) {
                continue;
            }

            $stmtCheck = $conn->prepare("SELECT COUNT(*) FROM clientes WHERE documento = :dni");
            $stmtCheck->execute(['dni' => $dni]);
            $count = (int) $stmtCheck->fetchColumn();

            if ($count > 0) {
                $stmtAmortizacion = $conn->prepare("UPDATE clientes SET amortizacion = amortizacion + :monto WHERE documento = :dni AND 'activo' = (SELECT MAX(estado) FROM caja WHERE estado='activo')");
                $stmtAmortizacion->execute([
                    'monto' => $monto,
                    'dni' => $dni
                ]);

                $stmtSaldo = $conn->prepare("SELECT saldo FROM clientes WHERE documento = :dni");
                $stmtSaldo->execute(['dni' => $dni]);
                $saldo_actualizado = $stmtSaldo->fetchColumn();

                if ($saldo_actualizado === false) {
                    throw new Exception("No se encontró el cliente con el documento: $dni");
                }

                $stmtHistorial = $conn->prepare("INSERT INTO historialpagos (cantidad, detalle, dni, nombrecajero, metodopago, fecha) VALUES (:monto, :detalle, :dni, :cajero, 'PAGOCLIENTEBANCO', NOW())");
                $stmtHistorial->execute([
                    'monto' => $monto,
                    'detalle' => $detalle,
                    'dni' => $dni,
                    'cajero' => $cajero
                ]);

                $stmtCaja = $conn->prepare("UPDATE caja SET banco = banco + :monto WHERE estado = 'activo'");
                $stmtCaja->execute(['monto' => $monto]);

                $stmtHistorialCaja = $conn->prepare("INSERT INTO historialcaja (tipo, ingreso, detalle, dni, nombrecajero, idcaja, fecha) VALUES ('PAGOCLIENTEBANCO', :monto, :detalle, :dni, :cajero, (SELECT MAX(id) FROM caja), NOW())");
                $stmtHistorialCaja->execute([
                    'monto' => $monto,
                    'detalle' => $detalle,
                    'dni' => $dni,
                    'cajero' => $cajero
                ]);

                $stmtVenta = $conn->prepare("INSERT INTO ventas (id_cliente, id_vendedor, productos, impuesto, neto, total, detalle, estado, pagosclientes, vendedor, fecha, cliente, codigo, saldo) VALUES (:dni, :vendedor, '0', '0', '0', '0', :detalle, 'PAGO CLIENTES BANCO', :monto, :cajero, NOW(), :dni2, '01', :saldo)");
                $stmtVenta->execute([
                    'dni' => $dni,
                    'dni2' => $dni,
                    'vendedor' => $idvendedor,
                    'detalle' => $detalle,
                    'monto' => $monto,
                    'cajero' => $cajero,
                    'saldo' => $saldo_actualizado
                ]);

                $stmtUpHist = $conn->prepare("UPDATE historialpagos hp JOIN clientes c ON hp.dni = c.documento SET hp.idcliente = c.id, hp.cliente = c.nombre WHERE hp.idcliente IS NULL OR hp.idcliente = ''");
                $stmtUpHist->execute();

                $stmtUpCajaHist = $conn->prepare("UPDATE historialcaja hc JOIN clientes c ON hc.dni = c.documento SET hc.idcliente = c.id, hc.cliente = c.nombre WHERE hc.idcliente IS NULL OR hc.idcliente = ''");
                $stmtUpCajaHist->execute();
            }

            $stmtDatos = $conn->prepare("INSERT INTO datos_excel (dni, monto, detalle, fecha) VALUES (:dni, :monto, :detalle, NOW())");
            $stmtDatos->execute([
                'dni' => $dni,
                'monto' => $monto,
                'detalle' => $detalle
            ]);
        }

        $conn->commit();

        echo "<!DOCTYPE html>
           <html lang='es'>
           <head>
               <meta charset='UTF-8'>
               <title>Redirigiendo...</title>
               <script>
                   setTimeout(function() {
                       window.location.href = 'excelpagosbanco';
                   }, 3000);
               </script>
           </head>
           <body>
               <p>Datos insertados correctamente. Serás redirigido en 3 segundos...</p>
           </body>
           </html>";
    } catch (Exception $e) {
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }

        echo "Error al procesar el archivo: " . $e->getMessage();
    }
}
