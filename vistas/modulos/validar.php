<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            administrar validar

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> inicio</a></li>

            <li class="active">administrar</li>
        </ol>
    </section>

    <!-- Main content -->

    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">

                <?php
                require_once __DIR__ . "/../../modelo/conexion.php";

                $conn = Conexion::conectar();

                // Consultar datos de ambas tablas
                $query_datos_excel = "SELECT * FROM datos_excel ORDER BY `datos_excel`.`id` DESC";

                // Ejecutar la consulta para datos_excel
                try {
                    $result_datos_excel = $conn->query($query_datos_excel);
                } catch (PDOException $e) {
                    die("Error en la consulta de datos_excel: " . $e->getMessage());
                }

                if (!$result_datos_excel) {
                    die("No se pudo cargar la tabla datos_excel.");
                }

                $datos_excel = $result_datos_excel->fetchAll(PDO::FETCH_ASSOC);

                if (count($datos_excel) === 0) {
                    echo "No hay datos en datos_excel.<br>";
                }

               
                ?>







<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<style>
    .invalid {
        background-color: red;
        color: white;
    }
</style>


<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Datos Excel</h3>
                </div>
                <div class="box-body">
                    <table id="tablas2" class="table table-bordered table-striped dt-responsive tablas">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th>id</th>
                            <th>DNI</th>
                            <th>Fecha</th>
                                <th>Monto</th>
                                <th>Validado</th>
                                <th>Observado</th>
                                <th>Detalle</th>
                                <th>Ver</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $sum = 0; ?>
                        <?php foreach ($datos_excel as $row): $sum++; ?>
                            <tr>
                                <td><?php echo htmlspecialchars($sum); ?></td>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['dni']); ?></td>
                                <td><?php echo htmlspecialchars($row['fecha']); ?></td>
                                <td><?php echo htmlspecialchars($row['monto']); ?></td>
                                <td class="<?php echo ($row['validado'] != 1) ? 'invalid' : ''; ?>">
                                    <?php echo htmlspecialchars($row['validado']); ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['observado']); ?></td>
                                <td><?php echo htmlspecialchars($row['detalle']); ?></td>
                                <td>
                                    <button class="btn btn-primary btnver" id="<?php echo $row["dni"]; ?>" data-toggle="modal" data-target="#modalver">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<!-- Modal -->
<div id="modalver" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background:#3c8dbc; color:white">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detalles de PAGOS</h4>
            </div>
            <div class="box-body"style="overflow-y: scroll;">
            <!-- Tabla para mostrar los datos -->
                <table id="tablaPersonas" class="table table-bordered table-striped dt-responsive tablas">

                    <thead>
                        <tr>
                            <th>NOMBRE</th>
                            <th>CANTIDAD</th>
                            <th>DNI</th> <!-- Puedes cambiar o agregar más columnas -->
                            <th>FECHA</th> <!-- Puedes cambiar o agregar más columnas -->
                            <th>METODO</th> <!-- Puedes cambiar o agregar más columnas -->
                            <th>DETALLE</th> <!-- Puedes cambiar o agregar más columnas -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí se llenarán dinámicamente las filas de la tabla -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>







<script>

$(document).ready(function() {

  


    $('.btnver').on('click', function() {
        // Obtener el ID del botón
        var id = $(this).attr('id');
 

        // Hacer una solicitud AJAX para obtener los datos de la persona
        $.ajax({
            url: 'obtener_pagos_persona.php', // archivo que obtiene los datos
            method: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                // Limpiar la tabla anterior
                $('#tablaPersonas tbody').empty();

                // Verificar si la respuesta contiene datos
                if (response.length > 0) {
                    // Iterar sobre cada fila devuelta por el servidor
                    response.forEach(function(persona) {
                        // Crear una nueva fila para cada persona
                        var fila = '<tr>' +
                            '<td>' + persona.nombre + '</td>' +
                            '<td>' + persona.cantidad + '</td>' +
                            '<td>' + persona.dni + '</td>' +
                            '<td>' + persona.fecha + '</td>' +
                            '<td>' + persona.metodopago + '</td>' +
                            '<td>' + persona.detalle + '</td>' +
                            '</tr>';
                        // Añadir la fila a la tabla
                        $('#tablaPersonas tbody').append(fila);
                    });
                } else {
                    // Si no hay datos, mostrar un mensaje en la tabla
                    var noDataRow = '<tr><td colspan="3">No se encontraron datos.</td></tr>';
                    $('#tablaPersonas tbody').append(noDataRow);
                }


                // Mostrar el modal
                $('#modalver').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Ocurrió un error: " + error);
            }
        });
    });
});

   
</script>







            </div>
        </div>
    </section>



</div>
