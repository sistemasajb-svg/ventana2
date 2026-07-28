<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario y sanitizarlos
    $nuevoVendedor = $_POST['nuevoVendedor'];
    $idVendedor = $_POST['idVendedor'];
    $selectcliente = $_POST['selectcliente'];
    $addsaldoanterior = $_POST['addsaldoanterior'];
    $addpago = $_POST['addpago'];
    $addsaldonuevo = $_POST['addsaldonuevo'];
    $addobservacion = $_POST['addobservacion'];
    $idabuscar = $_POST['idabuscar'];
    $fecha = date('Y-m-d H:i:s');

    // Conexión a la base de datos
    $servername = "host.cpse13.eu";
    $username = "y224661_useravicolajb";
    $password = "@exenk123456@";
    $dbname = "y224661_nuevabaseavicolajb";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Consulta preparada para insertar en historialpagos
    $sql_insert = "INSERT INTO historialpagos (idvendedor, idmasiva, cantidad, dni, detalle, nombrecajero, metodopago, fecha) 
            VALUES (?, ?, ?, ?, ?, ?, 'PAGOCLIENTE', ?)";
    $stmt_insert = $conn->prepare($sql_insert);

    // Verificar si la consulta se preparó correctamente
    if ($stmt_insert === false) {
        die("Error al preparar la consulta de inserción en historialpagos: " . $conn->error);
    }

    // Vincular parámetros y ejecutar la consulta de inserción en historialpagos
    $stmt_insert->bind_param("ssdssss", $idVendedor, $idabuscar, $addpago, $selectcliente, $addobservacion, $nuevoVendedor, $fecha);
    if ($stmt_insert->execute() === TRUE) {

        // Consulta para actualizar historialpagos
        $sql_update = "UPDATE historialpagos hp
        SET hp.cliente = (SELECT c.nombre FROM clientes c WHERE c.documento = hp.dni),
        idcliente = (SELECT c.id FROM clientes c WHERE c.documento = hp.dni)";
        // Ejecutar la consulta UPDATE
        if ($conn->query($sql_update) === TRUE) {
        } else {
            echo "Error al actualizar registros en historialpagos: " . $conn->error;
        } // Consulta para actualizar saldo del cliente
        $sql_cliente = "UPDATE clientes 
                            SET amortizacion = amortizacion + ?   
                            WHERE documento = ?";
        $stmt_cliente = $conn->prepare($sql_cliente);
        $stmt_cliente->bind_param("is", $addpago, $selectcliente);

        // Verificar si la consulta se preparó correctamente
        if ($stmt_cliente === false) {
            die("Error al preparar la consulta de actualización de saldo del cliente: " . $conn->error);
        }

        // Ejecutar la consulta de actualización de saldo del cliente
        if ($stmt_cliente->execute() === TRUE) {
            // La consulta se ejecutó con éxito
            $stmt_cliente->close();



            //UPDATE caja SET caja =caja + :nuevaamortizacion  WHERE estado = 'activo' 
            $sql_c = "UPDATE caja SET caja =caja + ?  WHERE estado = 'activo'";
            $stmt_caja = $conn->prepare($sql_c);
            $stmt_caja->bind_param("d", $addpago);

            // Verificar si la consulta se preparó correctamente
            if ($stmt_caja === false) {
                die("Error al preparar la consulta de actualización de saldo del cliente: " . $conn->error);
            }

            // Ejecutar la consulta de actualización de saldo del cliente
            if ($stmt_caja->execute() === TRUE) {
                // La consulta se ejecutó con éxito
                $stmt_caja->close();







              //INSERT INTO historialcaja(tipo,ingreso,detalle,cliente,dni,idcliente,nombrecajero,idcaja,fecha) 
              //VALUES('PAGOCLIENTE',:nuevaamortizacion ,:detalle,:nombre,:documento,:id,:nombrecajero,(SELECT MAX(id) FROM caja),:fecha) 
                $sql_cc = "INSERT INTO historialcaja(tipo,ingreso,detalle,dni,nombrecajero,idcaja,fecha) 
                VALUES('PAGOCLIENTE',? ,?,?,?,(SELECT MAX(id) FROM caja),?) 
                ";
                $stmt_cajaa = $conn->prepare($sql_cc);
                $stmt_cajaa->bind_param("sssss", $addpago,$addobservacion,$selectcliente,$nuevoVendedor,$fecha);

                // Verificar si la consulta se preparó correctamente
                if ($stmt_cajaa === false) {
                    die("Error al preparar la consulta de actualización de saldo del cliente: " . $conn->error);
                }

                // Ejecutar la consulta de actualización de saldo del cliente
                if ($stmt_cajaa->execute() === TRUE) {
                    // La consulta se ejecutó con éxito
                    $stmt_cajaa->close();
                } else {
                    // Ocurrió un error al ejecutar la consulta
                    echo "Error al actualizar saldo del cliente: " . $stmt_cliente->error;
                }








            } else {
                // Ocurrió un error al ejecutar la consulta
                echo "Error al actualizar saldo del cliente: " . $stmt_cliente->error;
            }
        } else {
            // Ocurrió un error al ejecutar la consulta
            echo "Error al actualizar saldo del cliente: " . $stmt_cliente->error;
        }
    } else {
        echo "Error al ejecutar la consulta de inserción en historialpagos: " . $stmt_insert->error;
    }

    // Cerrar el statement de inserción en historialpagos
    $stmt_insert->close();
    // Cerrar la conexión
    $conn->close();
}
