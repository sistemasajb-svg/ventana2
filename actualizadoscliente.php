<?php
// Aquí debes incluir la lógica para conectarte a tu base de datos y obtener los clientes actualizados
// Ejemplo básico utilizando PDO para conexión a MySQL

try {





    $clientes_actualizados = 0;
    $pdo = new PDO('mysql:host=host.cpse13.eu;dbname=y224661_nuevabaseavicolajb', 'y224661_useravicolajb', '@exenk123456@');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    $stmtUpdate = $pdo->prepare('UPDATE clientes SET saldo=total - amortizacion wHERE tipo = "Trabajador"');
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
