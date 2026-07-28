<?php
require_once __DIR__ . "/modelo/conexion.php";

try {
    $clientes_actualizados = 0;
    $pdo = Conexion::conectar();



    $stmtUpdate = $pdo->prepare('UPDATE clientes SET saldo = total - amortizacion WHERE tipo = "Trabajador"');
    $stmtUpdate->execute();
    // Consulta para obtener los clientes
    $stmt = $pdo->query('SELECT * FROM clientes where tipo = "Trabajador"');
    $clientes_actualizados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los clientes en formato JSON
    echo json_encode($clientes_actualizados);

} catch(PDOException $e) {
    echo 'Error al conectar con la base de datos: ' . $e->getMessage();
}
?>
