<?php

require_once __DIR__ . "/modelo/conexion.php";

if (isset($_GET['idabuscar'])) {
    $addprecio = (int) $_GET['idabuscar'];

    $conn = Conexion::conectar();
    $stmt = $conn->prepare("SELECT * FROM historialpagos WHERE idmasiva = :idmasiva");
    $stmt->bindParam(':idmasiva', $addprecio, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} else {
    echo json_encode([]);
}
