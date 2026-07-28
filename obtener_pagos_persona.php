
<?php
require_once __DIR__ . "/modelo/conexion.php";

$pdo = Conexion::conectar();



if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Preparar la consulta
    $stmt = $pdo->prepare("SELECT cliente as nombre, cantidad, dni, fecha, metodopago, detalle FROM historialpagos WHERE dni = :id ORDER BY fecha DESC");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Obtener todas las filas
    $personas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver las filas en formato JSON
    echo json_encode($personas);
} 
?>
