<?php
require 'vendor/autoload.php'; // Asegúrate de que la ruta sea correcta
require_once __DIR__ . "/modelo/conexion.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Obtener los datos de la base de datos
$pdo = Conexion::conectar();

$id1 = isset($_GET['idVenta']) ? intval($_GET['idVenta']) : 0;

// Buscar cliente
$stmtclientes = $pdo->prepare("SELECT id, nombre, documento FROM clientes WHERE id = :id ");
$stmtclientes->execute(['id' => $id1]);
$stmtclientes = $stmtclientes->fetch(PDO::FETCH_ASSOC);

if (!$stmtclientes) {
    echo "ID de cliente inválido.";
    exit;
}

$id = $stmtclientes["id"];
$nombre = $stmtclientes["nombre"];
$documento = $stmtclientes["documento"];

if ($id > 0) {
    try {
        // Datos de ventas
        $stmtVentas = $pdo->prepare("
            (SELECT 'V.ACTUAL' AS origen, cliente, total, detalle, fecha
                FROM ventas
                WHERE ((:id IS NULL OR id_cliente = :id)
                OR (:nombre IS NULL OR id_cliente = :nombre OR cliente LIKE CONCAT('%', :nombre, '%'))
                OR (:documento IS NULL OR id_cliente = :documento OR cliente = :documento))
            AND estado = 'Terminado')
            UNION ALL
            (SELECT 'V.ANTES' AS origen, cliente, total, detalle, fecha
                FROM venta23
                WHERE ((:id IS NULL OR id_cliente = :id)
                OR (:nombre IS NULL OR id_cliente = :nombre OR cliente LIKE CONCAT('%', :nombre, '%'))
                OR (:documento IS NULL OR id_cliente = :documento OR cliente = :documento))
            AND estado = 'Terminado')
        ");
        $stmtVentas->execute([
            'id' => $id,
            'nombre' => $nombre,
            'documento' => $documento
        ]);
        $ventas = $stmtVentas->fetchAll(PDO::FETCH_ASSOC);

        // Datos de pagos
        $stmtPagos = $pdo->prepare("
            (SELECT 'P.ACTUAL' AS origen, cantidad, cliente, dni, detalle, idcliente, fecha
                FROM historialpagos
                WHERE dni = :documento OR dni = :id
                OR idcliente = :id OR idcliente = :documento)
            UNION ALL
            (SELECT 'P.ANTES' AS origen, cantidad, cliente, dni, detalle, idcliente, fecha
                FROM historialpagosold
                WHERE dni = :documento OR dni = :id
                OR idcliente = :id OR idcliente = :documento)
        ");
        $stmtPagos->execute([
            'id' => $id,
            'documento' => $documento
        ]);
        $pagos = $stmtPagos->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error de consulta: " . $e->getMessage();
        exit;
    }
} else {
    echo "ID de cliente inválido.";
    exit;
}

// Crear el archivo Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Ventas
$sheet->setCellValue('A1', 'Ventas');
$sheet->setCellValue('A2', 'Origen');
$sheet->setCellValue('B2', 'Fecha');
$sheet->setCellValue('C2', 'Cliente');
$sheet->setCellValue('D2', 'Total');
$sheet->setCellValue('E2', 'Detalle');

$row = 3;
foreach ($ventas as $venta) {
    $sheet->setCellValue('A' . $row, $venta['origen']);
    $sheet->setCellValue('B' . $row, $venta['fecha']);
    $sheet->setCellValue('C' . $row, $venta['cliente']);
    $sheet->setCellValue('D' . $row, $venta['total']);
    $sheet->setCellValue('E' . $row, $venta['detalle']);
    $row++;
}

// Pagos
$sheet->setCellValue('A' . $row, 'Pagos');
$row++;
$sheet->setCellValue('A' . $row, 'Origen');
$sheet->setCellValue('B' . $row, 'Cliente');
$sheet->setCellValue('C' . $row, 'Cantidad');
$sheet->setCellValue('D' . $row, 'Fecha');
$sheet->setCellValue('E' . $row, 'Detalle');

$row++;
foreach ($pagos as $pago) {
    $sheet->setCellValue('A' . $row, $pago['origen']);
    $sheet->setCellValue('B' . $row, $pago['cliente']);
    $sheet->setCellValue('C' . $row, $pago['cantidad']);
    $sheet->setCellValue('D' . $row, $pago['fecha']);
    $sheet->setCellValue('E' . $row, $pago['detalle']);
    $row++;
}

// Forzar descarga del archivo
$writer = new Xlsx($spreadsheet);
$filename = 'reportes_' . date('Ymd') . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
