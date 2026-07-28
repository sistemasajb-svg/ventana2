<div class="content-wrapper">
    <section class="content-header">
        <h1>
        Reporte General
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> inicio</a></li>
            <li class="active">Masivas</li>
        </ol>
    </section>


    <script>
        jQuery(document).ready(function ($) {
            $(document).ready(function () {
                $('.mi-selector').select2();
            });
        });
    </script>





    <?php

    require_once __DIR__ . "/../../modelo/conexion.php";

    $pdo = Conexion::conectar();

    // Recuperar el ID de la venta desde la URL y asegurarse de que sea un número entero
    $id1 = isset($_GET['idVenta']) ? intval($_GET['idVenta']) : 0;


    //buscar cliente
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
            // Preparar y ejecutar la consulta para obtener datos de ventas actuales y antiguas
            $stmtVentas = $pdo->prepare("
            (SELECT 'V.ACTUAL' AS origen,  cliente, total, detalle, fecha
                FROM ventas
                WHERE ((:id IS NULL OR id_cliente = :id)
       OR (:nombre IS NULL OR id_cliente = :nombre OR cliente LIKE CONCAT('%', :nombre, '%'))
       OR (:documento IS NULL OR id_cliente = :documento OR cliente = :documento)
      )
  AND estado = 'Terminado')

            UNION ALL
            (SELECT 'V.ANTES' AS origen, cliente, total, detalle, fecha FROM venta23 
            WHERE ((:id IS NULL OR id_cliente = :id)
       OR (:nombre IS NULL OR id_cliente = :nombre OR cliente LIKE CONCAT('%', :nombre, '%'))
       OR (:documento IS NULL OR id_cliente = :documento OR cliente = :documento)
      )
  AND estado = 'Terminado')
        ");
            $stmtVentas->execute([
                'id' => $id,
                'nombre' => $nombre,
                'documento' => $documento
            ]);
            $ventas = $stmtVentas->fetchAll(PDO::FETCH_ASSOC);

            // Preparar y ejecutar la consulta para obtener datos de pagos actuales y antiguos
            $stmtPagos = $pdo->prepare("
            (SELECT 'P.ACTUAL' AS origen, cantidad, cliente,dni,detalle,idcliente ,fecha FROM historialpagos 
            WHERE dni = :documento OR dni = :id
            OR idcliente = :id OR idcliente = :documento)

            UNION ALL
            (SELECT 'P.ANTES' AS origen, cantidad, cliente,dni,detalle,idcliente ,fecha FROM historialpagosold 
            WHERE dni = :documento OR dni = :id
            OR idcliente = :id OR idcliente = :documento)
        ");
            $stmtPagos->execute([
                'id' => $id,
                'documento' => $documento
            ]);
            $pagos = $stmtPagos->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Manejar errores de consulta
            echo "Error de consulta: " . $e->getMessage();
            exit;
        }
    } else {
        echo "ID de cliente inválido.";
        exit;
    }
    ?>







    <section class="content">
        <div class="box">
            <div class="box-body" style="overflow-y: scroll;">

                <div class="col-lg-6 col-xs-12" style="border-right: 1px solid #ccc; padding-right: 15px;">




                <a href="exportargn.php?idVenta=<?php echo htmlspecialchars($id1); ?>" class="btn btn-success">Exportar a Excel</a>



                    <div class="table-container">


                        <!---------------->
                        <?php
                        // Inicializa las sumas totales
                        $totalGeneralVentas = 0;
                        $totalPActualVentas = 0;
                        $totalPAntesVentas = 0;

                        if ($ventas) {
                            foreach ($ventas as $venta) {
                                $total = (float) $venta['total']; // Convierte el total a flotante
                        
                                // Suma total general
                                $totalGeneralVentas += $total;

                                // Suma según el origen
                                if ($venta['origen'] === 'V.ACTUAL') {
                                    $totalPActualVentas += $total;
                                } elseif ($venta['origen'] === 'V.ANTES') {
                                    $totalPAntesVentas += $total;
                                }
                            }
                        }
                        ?>

                        <div class="total-container">
                            <h2>Ventas</h2>
                            <p><strong>Total General:</strong> <?php echo number_format($totalGeneralVentas, 2); ?></p>
                            <p><strong>Total v.ACTUAL:</strong> <?php echo number_format($totalPActualVentas, 2); ?></p>
                            <p><strong>Total v.ANTES:</strong> <?php echo number_format($totalPAntesVentas, 2); ?></p>
                        </div>
                        <!---------------->


                        <table id="tablas2" class="table table-bordered table-striped dt-responsive tablas">
                            <thead>
                                <tr>
                                    <th>Origen</th>
                                    <th>FECHA</th>
                                    <th>CLIENTE</th>
                                    <th>TOTAL</th>
                                    <th>DETALLE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($ventas): ?>

                                    <?php foreach ($ventas as $venta): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($venta['origen']); ?></td>
                                            <td><?php echo htmlspecialchars($venta['fecha']); ?></td>
                                            <td><?php echo htmlspecialchars($venta['cliente']); ?></td>
                                            <td><?php echo htmlspecialchars($venta['total']); ?></td>
                                            <td><?php echo htmlspecialchars($venta['detalle']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4">No se encontraron ventas con el ID proporcionado.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>











                </div>

                <div class="col-lg-6 col-xs-12" style="padding-left: 15px;">







                    <!-------------------->
                    <?php
                    // Inicializa las sumas totales
                    $totalGeneral = 0;
                    $totalPActual = 0;
                    $totalPAntes = 0;

                    if ($pagos) {
                        foreach ($pagos as $pago) {
                            $cantidad = (float) $pago['cantidad']; // Convierte la cantidad a flotante
                    
                            // Suma total general
                            $totalGeneral += $cantidad;

                            // Suma según el origen
                            if ($pago['origen'] === 'P.ACTUAL') {
                                $totalPActual += $cantidad;
                            } elseif ($pago['origen'] === 'P.ANTES') {
                                $totalPAntes += $cantidad;
                            }
                        }
                    }
                    ?>

                    <div class="total-container">
                        <h2>Pagos</h2>
                        <p><strong>Total General:</strong> <?php echo number_format($totalGeneral, 2); ?></p>
                        <p><strong>Total P.ACTUAL:</strong> <?php echo number_format($totalPActual, 2); ?></p>
                        <p><strong>Total P.ANTES:</strong> <?php echo number_format($totalPAntes, 2); ?></p>
                    </div>
                    <!--------------->



                    <table id="tablas21" class="table table-bordered table-striped dt-responsive tablas">
                        <thead>
                            <tr>
                                <th>Origen</th>
                                <th>cliente</th>
                                <th>Cantidad</th>
                                <th>Fecha</th>
                                <th>detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($pagos): ?>

                            <?php foreach ($pagos as $pago): ?>
                            <tr>
                                <td>
                                    <?php echo htmlspecialchars($pago['origen']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($pago['cliente']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($pago['cantidad']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($pago['fecha']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($pago['detalle']); ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="4">No se encontraron pagos con el ID proporcionado.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>













                </div>

            </div>
        </div>
    </section>

</div>
