    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                HISTORIAL DE VENTAS

            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> inicio</a></li>

                <li class="active">LISTADO DE VENTAS</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">

                </div>
                <div class="box-body">


                    <table id="tablasfiltrar" class="table table-bordered table-striped dt-responsive tablas" width="100%">

                        <thead>
                            <tr>
                                <th># </th>
                                <th>codigo preventa</th>
                                <th>cliente</th>
                                <th>vendedor</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>fecha</th>
                                <th>acciones</th>


                            </tr>



                        </thead>

                        <tbody>

                            <?php 



                                if ($_SESSION['perfil']=="SuperAdministrador" || $_SESSION['perfil']=="Administrador" || $_SESSION['perfil']=="Caja"|| $_SESSION['perfil']=="Ventas") {




                                    if(isset($_GET["fechaInicial"])){

                                        $fechaInicial=$_GET["fechaInicial"];
                                        $fechaFinal=$_GET["fechaFinal"];



                                    }else{


                                        $fechaInicial=null;
                                                                
                                                                
                                        $fechaFinal=null;


                                    }

                                    $respuesta=ControladorVerventas::ctrRangoFechasVentasTerminadas($fechaInicial,$fechaFinal);



                        



                                    //$Ventas=ControladorVentas::ctrMostrarVentas($item,$valor);


                                    foreach ($respuesta as $key => $value) {

                                        echo '

                                        <tr>

                                            <td>'.($key+1).'</td>
                                            <td>'.$value["codigo"].'</td>';

                                            $itemCliente="id";
                                            $valorCliente=$value["id_cliente"];

                                            $respuestaCliente=ControladorClientes::ctrMostrarClientes($itemCliente,$valorCliente);


                                            echo' <td>'.$respuestaCliente["nombre"].'</td>';

                                                $itemUsuario="id";
                                                $valorUsuario=$value["id_vendedor"];

                                            $respuestaUsuarios=ControladorUsuarios::ctrMostrarUsuarios($itemUsuario,$valorUsuario);


                                            echo'<td>'.$respuestaUsuarios["nombre"].'</td>
                                            <td>'.$value["total"].'</td>
                                            <td>'.$value["estado"].'</td>
                                            <td>'.$value["fecha"].'</td>';

                     



                                

                                            echo '<td>

                                                <div class="btn-group">

                                                <button class="btn btn-info btnImprimirFacturaFinal" codigoVenta="'.$value["codigo"].'" idVentas="'.$value["id"].'">

                                                <i class="fa fa-file-pdf-o"></i>
                                                </button>





                                                </div>

                                            </td>

                                        </tr> ';
                                
                                                                                                                                                                                   

                                    }
                            
                                }else{

                                    echo'<script>

                                    Swal.fire({
                                        type: "success",
                                        title: "NO TIENES ACCESO, Reportado (Enviando...)",
                                        showConfirmButton: true,
                                        confirmButtonText: "Cerrar"
                                        }).then(function(result){
                                                    if (result.value) {
        
                                                    window.location = "principal";
        
                                                    }
                                                })
        
                                    </script>';
        

                                }
                        
                                                                              
                            ?>


                        </tbody>





                    </table>


    <script>
        $(document).ready(function() {
        var table = $('#tablasfiltrar').DataTable( {
            fixedHeader: true,
            "language":{
                        "processing": "Procesando...",
                    "lengthMenu": "Mostrar _MENU_ 100 Ultimos registros",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "Ningún dato disponible en esta tabla",
                    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros Para Ventas antiguas solicite REPORTE)",
                    "search": "Buscar:",
                    "infoThousands": ",",
                    "loadingRecords": "Cargando...",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad",
                        "collection": "Colección",
                        "colvisRestore": "Restaurar visibilidad",
                        "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
                        "copySuccess": {
                            "1": "Copiada 1 fila al portapapeles",
                            "_": "Copiadas %d fila al portapapeles"
                        },
                        "copyTitle": "Copiar al portapapeles",
                        "csv": "CSV",
                        "excel": "Excel",
                        "pageLength": {
                            "-1": "Mostrar todas las filas",
                            "1": "Mostrar 1 fila",
                            "_": "Mostrar %d filas"
                        },
                        "pdf": "PDF",
                        "print": "Imprimir"
                    },
                    "autoFill": {
                        "cancel": "Cancelar",
                        "fill": "Rellene todas las celdas con <i>%d<\/i>",
                        "fillHorizontal": "Rellenar celdas horizontalmente",
                        "fillVertical": "Rellenar celdas verticalmentemente"
                    },
                    "decimal": ",",
                    "searchBuilder": {
                        "add": "Añadir condición",
                        "button": {
                            "0": "Constructor de búsqueda",
                            "_": "Constructor de búsqueda (%d)"
                        },
                        "clearAll": "Borrar todo",
                        "condition": "Condición",
                        "conditions": {
                            "date": {
                                "after": "Despues",
                                "before": "Antes",
                                "between": "Entre",
                                "empty": "Vacío",
                                "equals": "Igual a",
                                "notBetween": "No entre",
                                "notEmpty": "No Vacio",
                                "not": "Diferente de"
                            },
                            "number": {
                                "between": "Entre",
                                "empty": "Vacio",
                                "equals": "Igual a",
                                "gt": "Mayor a",
                                "gte": "Mayor o igual a",
                                "lt": "Menor que",
                                "lte": "Menor o igual que",
                                "notBetween": "No entre",
                                "notEmpty": "No vacío",
                                "not": "Diferente de"
                            },
                            "string": {
                                "contains": "Contiene",
                                "empty": "Vacío",
                                "endsWith": "Termina en",
                                "equals": "Igual a",
                                "notEmpty": "No Vacio",
                                "startsWith": "Empieza con",
                                "not": "Diferente de"
                            },
                            "array": {
                                "not": "Diferente de",
                                "equals": "Igual",
                                "empty": "Vacío",
                                "contains": "Contiene",
                                "notEmpty": "No Vacío",
                                "without": "Sin"
                            }
                        },
                        "data": "Data",
                        "deleteTitle": "Eliminar regla de filtrado",
                        "leftTitle": "Criterios anulados",
                        "logicAnd": "Y",
                        "logicOr": "O",
                        "rightTitle": "Criterios de sangría",
                        "title": {
                            "0": "Constructor de búsqueda",
                            "_": "Constructor de búsqueda (%d)"
                        },
                        "value": "Valor"
                    },
                    "searchPanes": {
                        "clearMessage": "Borrar todo",
                        "collapse": {
                            "0": "Paneles de búsqueda",
                            "_": "Paneles de búsqueda (%d)"
                        },
                        "count": "{total}",
                        "countFiltered": "{shown} ({total})",
                        "emptyPanes": "Sin paneles de búsqueda",
                        "loadMessage": "Cargando paneles de búsqueda",
                        "title": "Filtros Activos - %d"
                    },
                    "select": {
                        "1": "%d fila seleccionada",
                        "_": "%d filas seleccionadas",
                        "cells": {
                            "1": "1 celda seleccionada",
                            "_": "$d celdas seleccionadas"
                        },
                        "columns": {
                            "1": "1 columna seleccionada",
                            "_": "%d columnas seleccionadas"
                        }
                    },
                    "thousands": ".",
                    "datetime": {
                        "previous": "Anterior",
                        "next": "Proximo",
                        "hours": "Horas",
                        "minutes": "Minutos",
                        "seconds": "Segundos",
                        "unknown": "-",
                        "amPm": [
                            "am",
                            "pm"
                        ]
                    },
                    "editor": {
                        "close": "Cerrar",
                        "create": {
                            "button": "Nuevo",
                            "title": "Crear Nuevo Registro",
                            "submit": "Crear"
                        },
                        "edit": {
                            "button": "Editar",
                            "title": "Editar Registro",
                            "submit": "Actualizar"
                        },
                        "remove": {
                            "button": "Eliminar",
                            "title": "Eliminar Registro",
                            "submit": "Eliminar",
                            "confirm": {
                                "_": "¿Está seguro que desea eliminar %d filas?",
                                "1": "¿Está seguro que desea eliminar 1 fila?"
                            }
                        },
                        "error": {
                            "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\/a&gt;).<\/a>"
                        },
                        "multi": {
                            "title": "Múltiples Valores",
                            "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
                            "restore": "Deshacer Cambios",
                            "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
                        }
                    },
                    "info": "Mostrando de _START_ a _END_ de _TOTAL_ entradas"
                } 


            } );
        } );
    </script>




                </div>

            </div>


        </section>

    </div>







