<!-- Content Wrapper. Contains page content -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


<style>
    .container2 {
        position: relative;
        display: inline-block;
    }

    .trigger {
        cursor: pointer;
        text-align: center;
        padding: 5px;
        border-radius: 50%;
        width: 55px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .trigger:hover {
        background: rgb(209, 209, 209);
    }

    .submenu {
        display: none;
        position: absolute;
        background-color: #fff;
        border: 1px solid #ccc;
        z-index: 9;
        border-radius: 5px;
        width: 180px;
        padding: 5px;
    }

    /* .submenu {
    display: none;
    position: absolute;
    background-color: #fff;
    border: 1px solid #ccc;
} */

    .item-submenu {
        font-size: 14px;
        text-decoration: none;
        color: #333;
        display: flex;
        gap: 5px;
        align-items: center;
        cursor: pointer;
    }

    .item-submenu:hover {
        background: #e6e6e6;
    }

    .submenu ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .submenu ul li {
        padding: 7px 5px;
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Administrar cajas

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> inicio</a></li>

            <li class="active">administrar cajas</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">


                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCaja">
                    Aperturar caja
                </button>


            </div>






            <div style=" height: 700px; overflow-y: scroll;">
                <div class="box-body">

                    <table class="table table-bordered table-striped dt-responsive tablas" width="100%">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>CAJA EFECTIVO</th>
                                <th>BANCO</th>
                                <th>FECHA APERTURA</th>
                                <th>FECHA CIERRE</th>
                                <th>DETALLE</th>
                                <th>REPORTE</th>
                                <th>ESTADO</th>


                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            if ($_SESSION['perfil'] == "Caja2" || $_SESSION['perfil'] == "Administrador" || $_SESSION['perfil'] == "Caja") {


                                $item = null;


                                $valor = null;


                                $item2 = "id";


                                $valor2 = "caja";


                                $cajas = ControladorCajas::ctrMostrarCajas($item, $valor);
                                $ultimomonto = ControladorCajas::ctrMostrarCajasmonto($item2, $valor2);
                                $montocajaultimo = $ultimomonto["caja"];


                                foreach ($cajas as $key => $value) {

                                    echo '

                                                <tr>

                                                <td>' . $value["id"] . '</td>
                                                <td>' . $value["caja"] . '</td>
                                                <td>' . $value["banco"] . '</td>
                                                <td>' . $value["fecha"] . '</td>
                                                <td>' . $value["fechacierre"] . '</td>
                                                <td>' . $value["detallecaja"] . '</td>
                                                ';

                                                echo '
                                                <td>
                                                    <div class="btn-group">
                                                        <div class="container2">
                                                            <div class="trigger" onclick="btn_menu(this)">
                                                                <i class="fas fa-ellipsis-v"> </i> Ver
                                                            </div>
                                                                    
                                                            <div class="submenu">
                                                                <ul>
                                                                    <li class="item-submenu btnImprimirFacturacaja" codigoVenta="' . $value["id"] . '">
                                                                        <i class="fas fa-file-alt"></i>
                                                                        <span>Reporte Actual</span>
                                                                    </li>
                                                                    
                                                                    
                                                                    <li class="item-submenu btnImprimirNewaFacturacaja" codigoVenta="' . $value["id"] . '">
                                                                        <i class="fas fa-file-alt"></i>
                                                                        <span>Reporte Nuevo</span>
                                                                    </li>  
                                                                    <li class="item-submenu btnEnviarWhatsApp" codigoVenta="' . $value["id"] . '">
                                                                        <i class="fab fa-whatsapp"></i>
                                                                        <span>Enviar a WhatsApp</span>
                                                                    </li>                                                              
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                ';


                                                if ($value["estado"] == "activo") {

                                                    echo '<td><button class="btn btn-success btn-xs btnActivarcajas" idCaja="' . $value["id"] . '" estadoCaja="activo">Activado</button></td>';

                                                } else {

                                                    echo '<td><button class="btn btn-danger btn-xs btnActivarcajas" idCaja="' . $value["id"] . '" estadoCaja="desactivo">Desactivado</button></td>';

                                                }



                                                echo '</tr>';




                                }
                            } else {

                                echo '<script>

                                    Swal.fire({
                                        type: "success",
                                        title: "NO TIENES ACCESO, Reportado. (Enviando...)",
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





                </div>

            </div>


    </section>

</div>



<script>
//     $(document).on("click", ".btnEnviarWhatsApp", function() {
//     var codigoVenta = $(this).attr("codigoVenta");
//     var urlPDF = window.location.origin + "/extensiones/examples/cajaa5.php?id=" + codigoVenta;

//     // Número de WhatsApp al que deseas enviar (sin el "+")
//     var numeroWhatsApp = "51999999999"; // Reemplaza con el número correcto

//     // Mensaje de WhatsApp con enlace al PDF
//     var mensaje = "Hola, aquí tienes el reporte en PDF: " + encodeURIComponent(urlPDF);

//     // Generar la URL de WhatsApp
//     var urlWhatsApp = "https://api.whatsapp.com/send?phone=" + numeroWhatsApp + "&text=" + mensaje;

//     // Abrir WhatsApp en una nueva ventana
//     window.open(urlWhatsApp, "_blank");
// });

$(document).on("click", ".btnEnviarWhatsApp", function() {
    var codigoVenta = $(this).attr("codigoVenta");
    var urlPDF = window.location.origin + "/extensiones/examples/cajaa5.php?id=" + codigoVenta;

    // Mensaje de WhatsApp con enlace al PDF
    var mensaje = "Hola, aquí tienes el reporte en PDF: " + encodeURIComponent(urlPDF);

    // Generar la URL de WhatsApp sin número predefinido
    var urlWhatsApp = "https://api.whatsapp.com/send?text=" + mensaje;

    // Abrir WhatsApp en una nueva ventana
    window.open(urlWhatsApp, "_blank");
});



</script>









<!--=====================================
MODAL AGREGAR CAJA
======================================-->
<div id="modalAgregarCaja" class="modal fade" role="dialog">

    <div class="modal-dialog">

        <div class="modal-content">


            <form role="form" method="post" enctype="multipart/form-data">

                <!--=====================================
                    CABEZA DEL MODAL
                    ======================================-->


                <div class="modal-header" style="background:#3c8dbc; color:white">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title">Aperturar caja</h4>

                </div>

                <!--=====================================
                    CUERPO DEL MODAL
                    ======================================-->

                <div class="modal-body">
                    <div class="box-body">

                        <!-- ENTRADA PARA EL aqui va la cantidad -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                <input type="text" class="form-control input-lg" value="<?php echo $montocajaultimo; ?>"
                                    name="nuevoMonto" placeholder="Ingresar Monto" required readonly>




                            </div>

                        </div>

                        <!-- ENTRADA detalle caja -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-commenting"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevodetallecaja"
                                    placeholder="Ingresar detalle" required>

                            </div>

                        </div>

                    </div>

                </div>

                <!--=====================================
                    PIE DEL MODAL
                    ======================================-->

                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                    <button type="submit" class="btn btn-primary" id="btnGo">Aperturar caja</button>

                </div>

                <?php

                $crearCaja = new ControladorCajas();
                $crearCaja->ctrCrearCajas();



                ?>






            </form>

        </div>
    </div>
</div>