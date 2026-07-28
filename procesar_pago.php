<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevoVendedor = $_POST['nuevoVendedor'];
    $idVendedor = $_POST['idVendedor'];
    $selectcliente = $_POST['selectcliente'];
    $addpago = $_POST['addpago'];
    $addobservacion = $_POST['addobservacion'];
    $idabuscar = $_POST['idabuscar'];
    $fecha = date('Y-m-d H:i:s');

    require_once __DIR__ . "/modelo/conexion.php";

    $conn = Conexion::conectar();

    try {
        $conn->beginTransaction();

        $stmt_insert = $conn->prepare("INSERT INTO historialpagos (idvendedor, idmasiva, cantidad, dni, detalle, nombrecajero, metodopago, fecha) VALUES (:idvendedor, :idmasiva, :cantidad, :dni, :detalle, :nombrecajero, 'PAGOCLIENTE', :fecha)");
        $stmt_insert->execute([
            'idvendedor' => $idVendedor,
            'idmasiva' => $idabuscar,
            'cantidad' => $addpago,
            'dni' => $selectcliente,
            'detalle' => $addobservacion,
            'nombrecajero' => $nuevoVendedor,
            'fecha' => $fecha
        ]);

        $stmt_update = $conn->prepare("UPDATE historialpagos hp SET hp.cliente = (SELECT c.nombre FROM clientes c WHERE c.documento = hp.dni), idcliente = (SELECT c.id FROM clientes c WHERE c.documento = hp.dni)");
        $stmt_update->execute();

        $stmt_cliente = $conn->prepare("UPDATE clientes SET amortizacion = amortizacion + :pago WHERE documento = :dni");
        $stmt_cliente->execute([
            'pago' => $addpago,
            'dni' => $selectcliente
        ]);

        $stmt_caja = $conn->prepare("UPDATE caja SET caja = caja + :pago WHERE estado = 'activo'");
        $stmt_caja->execute(['pago' => $addpago]);

        $stmt_cajaa = $conn->prepare("INSERT INTO historialcaja(tipo,ingreso,detalle,dni,nombrecajero,idcaja,fecha) VALUES ('PAGOCLIENTE', :ingreso, :detalle, :dni, :nombrecajero, (SELECT MAX(id) FROM caja), :fecha)");
        $stmt_cajaa->execute([
            'ingreso' => $addpago,
            'detalle' => $addobservacion,
            'dni' => $selectcliente,
            'nombrecajero' => $nuevoVendedor,
            'fecha' => $fecha
        ]);

        $conn->commit();
    } catch (Exception $e) {
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        die("Error al procesar el pago: " . $e->getMessage());
    }
}
