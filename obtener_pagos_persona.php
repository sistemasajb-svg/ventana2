
<?php
// Conexión a la base de datos usando PDO
$host = 'host.cpse13.eu'; // Cambia esto por la dirección de tu servidor de base de datos
$dbname = 'y224661_nuevabaseavicolajb'; // Cambia esto por el nombre de tu base de datos
$username = 'y224661_useravicolajb'; // Cambia esto por tu nombre de usuario de MySQL
$password = '@exenk123456@'; // Cambia esto por tu contraseña de MySQL

try {
    // Crear la conexión usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configurar el modo de error de PDO para lanzar excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Mostrar error si falla la conexión
    die("Error de conexión: " . $e->getMessage());
}



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
