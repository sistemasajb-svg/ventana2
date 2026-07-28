    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                PAGOS DE BANCO -

                <a href="formatoexcel/formatojb.xlsx" download class="btn btn-primary col start">
                    <i class="fas fa-download"></i>
                    <span>Descargar formato Excel</span>
                    <i class="fas fa-file-excel"></i>
                </a>


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



                    <form id="uploadForm" action="guardarenbd.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="fileInput" class="form-label">Selecciona un archivo Excel:</label>
                            <input type="file" id="fileInput" name="file" class="form-control" accept=".xlsx, .xls" required>
                        </div>

                        <div id="actions" class="row">
                            <div class="col-lg-6">
                                <div class="btn-group w-100">
                                    <button type="submit" class="btn btn-primary col start" style="background-color: green; border-color: green;">
                                        <i class="fas fa-upload"></i>
                                        <span>Empezar a subir</span>
                                    </button>
                                </div>
                                <div class="btn-group w-100">
                                    <button type="reset" id="cancelButton" class="btn btn-warning col cancel">
                                        <i class="fas fa-times-circle"></i>
                                        <span>Cancelar vista previa</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>





                </div>
                <div class="box-body">












                    <div class="col-lg-6 col-xs-12" style="border-right: 1px solid #0b0062; padding-right: 15px;">

                        <!--------------->
                        <!--------------->
                        <!--------<div style="overflow-y: scroll;">------->

                        <div class="box-body" style="height: 400px; overflow-y: auto;">
                            <label for="fileInput" class="form-label">Vista previa del excel a procesar:</label>
                            <div id="preview" class="table-responsive bg-white border border-primary rounded shadow-sm"></div>
                        </div>

                        <!-- FontAwesome CSS -->
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
                        <!-- SheetJS (XLSX) -->
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>


                        <style>
                            /* Estilos para la vista previa */
                            #preview table {
                                width: 100%;
                                border-collapse: collapse;
                                margin-top: 1rem;
                            }

                            #preview th,
                            #preview td {
                                padding: 12px;
                                text-align: left;
                                border: 1px solid #dee2e6;
                            }

                            #preview th {
                                background-color: #007bff;
                                /* Color de fondo del encabezado */
                                color: #fff;
                                /* Color del texto del encabezado */
                            }

                            #preview tr:nth-child(even) {
                                background-color: #f9f9f9;
                                /* Color de fondo alternado para filas */
                            }

                            #preview tr:hover {
                                background-color: #e9ecef;
                                /* Color de fondo al pasar el mouse */
                            }
                        </style>

                        <script>
                            document.getElementById('fileInput').addEventListener('change', function(event) {
                                const file = event.target.files[0];
                                if (file) {
                                    const reader = new FileReader();

                                    reader.onload = function(e) {
                                        const data = new Uint8Array(e.target.result);
                                        const workbook = XLSX.read(data, {
                                            type: 'array'
                                        });
                                        const sheetName = workbook.SheetNames[0];
                                        const sheet = workbook.Sheets[sheetName];
                                        const html = XLSX.utils.sheet_to_html(sheet, {
                                            header: ""
                                        });

                                        // Escapa el HTML para evitar problemas de seguridad y asegúrate de que se muestra correctamente
                                        document.getElementById('preview').innerHTML = html;
                                    };

                                    reader.readAsArrayBuffer(file);
                                }
                            });
                        </script>
                        <!--------------->
                        <!--------------->
                        <!--------------->
                        <!--------------->
                        <!------ <table id="tablas2" class="table table-bordered table-striped dt-responsive tablas mt-3">--------->

                    </div>

                    <div class="col-lg-6 col-xs-12" style="border-left: 2px solid #0b0062; padding-right: 15px;">

                        <label for="fileInput" class="form-label">Pagos procesados:</label>
                        <input type="date" id="dateInput" name="dateInput" readonly>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                var dateInput = document.getElementById("dateInput");
                                var today = new Date().toISOString().split('T')[0];
                                dateInput.value = today;
                            });
                        </script>


                        <div class="box-body" style="height: 400px; overflow-y: auto;">


                           
                            <table id="tablas2" class="table table-bordered table-striped dt-responsive tablas">
    <thead>
        <tr>
            <th style="width:10px">#</th>
            <th>NOMBRE</th>
            <th>DOCUMENTO</th>
            <th>MONTO</th>
            <th>DETALLE</th>
            <th>FECHA</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $tabla = 'datos_excel';
        $exee = ControladorPagos::ctr_ver_tabla_excel($tabla);

        foreach ($exee as $key => $value) {
            $nombre = !empty($value["nombre"]) ? $value["nombre"] : '<span style="color: white; background-color: red; padding: 2px; border-radius: 5px;">No procesado</span>';

            // Verificar si "validado" es diferente de 1
            $estado = $value["validado"] != 1 
                ? '<span style="color: white; background-color: red; padding: 2px; border-radius: 5px;">Error</span>' 
                : $value["validado"];

            echo '
            <tr>
                <td>' . ($key + 1) . '</td>                            
                <td>' . $nombre . '</td>
                <td>' . $value["dni"] . '</td>
                <td>' . $value["monto"] . '</td>
                <td>' . $value["detalle"] . '</td>
                <td>' . $value["fecha"] . '</td>
                <td>' . $estado . '</td>
            </tr>';
        }
        ?>
    </tbody>
</table>
            
                                        <a href="validar" style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-align: center; text-decoration: none; border-radius: 5px;">Ver Todos</a>
               
                           

                        </div>
                    </div>

























                </div>

            </div>


        </section>

    </div>