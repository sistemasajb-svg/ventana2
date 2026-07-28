<?php
if (isset($_GET['idabuscar'])) {
    $addprecio = $_GET['idabuscar'];

    $servername = "host.cpse13.eu";
    $username = "y224661_useravicolajb";
    $password = "@exenk123456@";
    $database = "y224661_nuevabaseavicolajb";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM historialpagos WHERE idmasiva = $addprecio";
    $result = $conn->query($sql);

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    echo json_encode($data);

    $conn->close();
} else {
    echo json_encode([]);
}
?>
