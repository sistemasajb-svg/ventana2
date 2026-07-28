<?php

session_start();

// Establecer la zona horaria a Perú
date_default_timezone_set('America/Lima');  // Establecer la zona horaria de Perú


require 'vendor/autoload.php'; // Asegúrate de que esta ruta sea correcta

use PhpOffice\PhpSpreadsheet\IOFactory;

// Configuración de la base de datos
$servername = "host.cpse13.eu";
$username = "y224661_useravicolajb";
$password = "@exenk123456@";
$dbname = "y224661_nuevabaseavicolajb";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$cajero = $_SESSION["nombre"];
$idvendedor = $_SESSION["id"];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $fileTmpPath = $_FILES['file']['tmp_name'];

    // Cargar el archivo Excel
    $spreadsheet = IOFactory::load($fileTmpPath);
    $sheet = $spreadsheet->getActiveSheet();

    // Leer los datos desde la fila 2
    $highestRow = $sheet->getHighestRow();

    // Iniciar la transacción
    $conn->begin_transaction();

    try {

        for ($row = 2; $row <= $highestRow; $row++) {
            $dni = $sheet->getCell('A' . $row)->getValue();
            $monto = $sheet->getCell('B' . $row)->getValue();
            $detalle = $sheet->getCell('C' . $row)->getValue();





            // Validar monto mayor a cero
            if (is_numeric($monto) && $monto > 0) {

                // Verificar si el DNI existe en la tabla clientes
                $check_dni = "SELECT COUNT(*) FROM clientes WHERE documento = '$dni'";
                $result = $conn->query($check_dni);

                if ($result) {
                    $count = $result->fetch_row()[0];
                    if ($count > 0) {
                        // El DNI existe, proceder con las actualizaciones

                        // Validar monto mayor a cero
                        if (is_numeric($monto) && $monto > 0) {
                            // Escapar los datos para evitar inyecciones SQL
                            $dni = $conn->real_escape_string($dni);
                            $monto = $conn->real_escape_string($monto);
                            $detalle = $conn->real_escape_string($detalle);

                            // ADD AMORTIZACION A CLIENTE
                            // ADD AMORTIZACION A CLIENTE
                            // ADD AMORTIZACION A CLIENTE
                            // ADD AMORTIZACION A CLIENTE
                            $sql_cli_amor = "UPDATE clientes SET amortizacion =amortizacion + '$monto' WHERE documento = $dni and 'activo'=(SELECT MAX(estado)FROM caja WHERE estado='activo')";
                            if (!$conn->query($sql_cli_amor)) {
                                echo "Error: " . $conn->error;
                            }

                            $sqlupdtsaldo = "UPDATE clientes SET saldo = total - amortizacion where documento = '$dni'";
                            if (!$conn->query($sqlupdtsaldo)) {
                                throw new Exception("Error en inserción de datos_excel: " . $conn->error);
                            }

                            // Ahora obtienes el saldo actualizado
                            $sql_get_saldo = "SELECT saldo FROM clientes WHERE documento = '$dni'";
                            $resultt = $conn->query($sql_get_saldo);
                            if ($resultt->num_rows > 0) {
                                $rows = $resultt->fetch_assoc();
                                $saldo_actualizado = $rows['saldo'];
                            } else {
                                throw new Exception("No se encontró el cliente con el documento: $dni");
                            }

                            // FIN AMORTIZACION A CLIENTE
                            // FIN AMORTIZACION A CLIENTE
                            // FIN AMORTIZACION A CLIENTE


                            // ADD HISTORIAL
                            $sql_histo = "INSERT INTO historialpagos (cantidad, detalle, dni, nombrecajero, metodopago, fecha) 
                              VALUES ('$monto', '$detalle', '$dni', '$cajero', 'PAGOCLIENTEBANCO', NOW())";
                            if (!$conn->query($sql_histo)) {
                                throw new Exception("Error en inserción de historial: " . $conn->error);
                            }

                            // ADD CAJA
                            $add_caja = "UPDATE caja SET banco = banco + '$monto' WHERE estado = 'activo'";
                            if (!$conn->query($add_caja)) {
                                throw new Exception("Error en actualización de caja: " . $conn->error);
                            }

                            // ADD HISTORIAL CAJA
                            $his_caja = "INSERT INTO historialcaja (tipo, ingreso, detalle, dni, nombrecajero, idcaja, fecha) 
                             VALUES ('PAGOCLIENTEBANCO', '$monto', '$detalle', '$dni', '$cajero', (SELECT MAX(id) FROM caja), NOW())";
                            if (!$conn->query($his_caja)) {
                                throw new Exception("Error en inserción de historial de caja: " . $conn->error);
                            }

                            // ADD VENTA
                            $add_venta = "INSERT INTO ventas (id_cliente, id_vendedor, productos, impuesto, neto, total, detalle, estado, pagosclientes, vendedor, fecha, cliente, codigo, saldo) 
                              VALUES ('$dni', '$idvendedor', '0', '0', '0', '0', '$detalle', 'PAGO CLIENTES BANCO', '$monto', '$cajero', NOW(), '$dni', '01', '$saldo_actualizado')";
                            if (!$conn->query($add_venta)) {
                                throw new Exception("Error en inserción de venta: " . $conn->error);
                            }


                            // LLENAR HISTORIA IDCLIENTE NOMBRE VENTA
                            $updhisto = "UPDATE historialpagos hp JOIN clientes c ON hp.dni = c.documento SET hp.idcliente = c.id, hp.cliente = c.nombre WHERE hp.idcliente IS NULL OR hp.idcliente = '';";
                            if (!$conn->query($updhisto)) {
                                throw new Exception("Error en inserción de venta: " . $conn->error);
                            }


                            // LLENAR historialcaja IDCLIENTE NOMBRE VENTA
                            $upd2histo2 = "UPDATE historialcaja hc JOIN clientes c ON hc.dni = c.documento SET hc.idcliente = c.id, hc.cliente = c.nombre WHERE hc.idcliente IS NULL OR hc.idcliente = '';";
                            if (!$conn->query($upd2histo2)) {
                                throw new Exception("Error en inserción de venta: " . $conn->error);
                            }




                        }


                    }
                }  
                
                // Insertar los datos en la base de datos
                $sql = "INSERT INTO datos_excel (dni, monto, detalle,fecha) VALUES ('$dni', '$monto', '$detalle', NOW())";
                if (!$conn->query($sql)) {
                    throw new Exception("Error en inserción de datos_excel: " . $conn->error);
                }

            }

        }

        // Confirmar la transacción
        $conn->commit();




        // Mostrar mensaje y redirigir después de 3 segundos
        echo "<!DOCTYPE html>
           <html lang='es'>
           <head>
               <meta charset='UTF-8'>
               <title>Redirigiendo...</title>
               <script>
                   setTimeout(function() {
                       window.location.href = 'excelpagosbanco';
                   }, 3000); // 3000 milisegundos = 3 segundos
               </script>
           </head>
           <body>
               <p>Datos insertados correctamente. Serás redirigido en 3 segundos...</p>
           </body>
           </html>";
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No se ha cargado ningún archivo.";
}

$conn->close();
