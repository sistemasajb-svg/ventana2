       <!-- Content Wrapper. Contains page content -->
       <div class="content-wrapper">
           <!-- Content Header (Page header) -->
           <section class="content-header">
               <h1>
                   Administrar pagos de los Clientes - VENTA HUEVOS

               </h1>
               <ol class="breadcrumb">
                   <li><a href="#"><i class="fa fa-dashboard"></i> inicio</a></li>

                   <li class="active">Administrar Pagos - HUEVOS</li>
               </ol>
           </section>
           
            <!-- Enlace a la CDN de Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">

           
            <!-- Contenedor de "Cargando..." -->
    <div id="loading">
        <i class="fas fa-spinner fa-spin fa-2x"></i> <!-- Icono de carga de Font Awesome -->
        <p>Cargando...</p>
    </div>
    
    
    
    <style>
        /* Estilos para el mensaje de "Cargando..." */
#loading {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7); /* Fondo oscuro, casi negro */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    font-size: 24px;
    font-family: Arial, sans-serif;
    z-index: 9999;
}

/* Estilo del texto de "Cargando..." */
#loading p {
    color: #fff;  /* Texto blanco, para un buen contraste con el fondo oscuro */
    font-weight: bold;
    margin-top: 10px; /* Espacio entre el icono y el texto */
}

/* Asegurarse de que el icono esté girando con "fa-spin" */
.fas.fa-spinner {
    color: #fff; /* El ícono también en blanco, para resaltar sobre el fondo oscuro */
}

    </style>

<script>
  // Espera a que la página se haya cargado completamente
window.onload = function() {
    // Ocultar el mensaje "Cargando..."
    document.getElementById("loading").style.display = "none";
    
    // Mostrar el contenido de la página
    document.getElementById("contenido").style.display = "block";
};

</script>
           <style>
               #message {
                   display: none;
                   position: fixed;
                   top: 50%;
                   left: 50%;
                   transform: translate(-50%, -50%);
                   z-index: 9999;
               }
           </style>
           <style>
               #message {
                   display: none;
               }
           </style>
           <div id="message" style="background-color: #ffcc00; color: #ffffff; padding: 10px; border-radius: 5px; text-align: center;">
               ¡Hace 5 seg. que no usas la página! Se actualizará en <span id="updateCountdown"></span>.
           </div>
           <div id="counter" style="font-size: 24px; font-weight: bold; text-align: center; margin-top: 10px;"></div>

           <script>
               // Tiempo de inactividad permitido (en milisegundos)
               const INACTIVITY_TIMEOUT = 5000;
               // Tiempo de actualización (en milisegundos)
               const UPDATE_INTERVAL = 1000 * 60 * 2; // 2 minutos en milisegundos

               let inactiveTimer;
               let updateTimer;
               let counter = 0;
               let isInactive = false;
               let countdownInterval;

               function showInactiveMessage() {
                   if (!isInactive) {
                       document.getElementById('message').style.display = 'block';
                       isInactive = true;
                   }
               }

               function hideInactiveMessage() {
                   document.getElementById('message').style.display = 'none';
                   isInactive = false;
               }

               function resetInactiveTimer() {
                   clearTimeout(inactiveTimer);
                   inactiveTimer = setTimeout(showInactiveMessage, INACTIVITY_TIMEOUT);
               }

               function resetUpdateTimer() {
                   clearInterval(updateTimer);
                   clearInterval(countdownInterval);
                   updateTimer = setInterval(updatePage, UPDATE_INTERVAL);
                   updateCountdown(UPDATE_INTERVAL / 1000);
               }

               function updatePage() {
                   alert('¡La página se actualizará en 2 minutos!');
                   // Aquí puedes realizar cualquier acción de actualización que necesites
                   // Por ejemplo:
                   location.reload();
               }

               function updateCounter() {
                   counter++;
                   //document.getElementById('counter').innerText = `Contador: ${counter} segundos`;
               }

               // Función para actualizar la cuenta regresiva para la próxima actualización
               function updateCountdown(seconds) {
                   let minutes = Math.floor(seconds / 60);
                   let remainingSeconds = seconds % 60;
                   document.getElementById('updateCountdown').innerText = `${minutes} min ${remainingSeconds} seg`;
                   // Actualiza la cuenta regresiva cada segundo
                   countdownInterval = setInterval(function() {
                       seconds--;
                       minutes = Math.floor(seconds / 60);
                       remainingSeconds = seconds % 60;
                       document.getElementById('updateCountdown').innerText = `${minutes} min ${remainingSeconds} seg`;
                       if (seconds <= 0) {
                           clearInterval(countdownInterval);
                       }
                   }, 1000);
               }

               // Agrega eventos para detectar actividad del usuario
               function handleUserActivity() {
                   if (isInactive) {
                       hideInactiveMessage();
                   }
                   resetInactiveTimer();
                   resetUpdateTimer();
                   counter = 0;
                   updateCounter();
               }

               document.addEventListener('mousemove', handleUserActivity);
               document.addEventListener('keypress', handleUserActivity);

               // Inicia el temporizador de inactividad y el temporizador de actualización
               resetInactiveTimer();
               resetUpdateTimer();
               updateCounter();
           </script>

           <!-- Main content -->
           <section class="content">

               <!-- Default box -->
               <div class="box">
                   <div class="box-header with-border">

                   
                   <?php
                        if ($_SESSION['perfil'] == "SuperAdministrador" || $_SESSION['perfil'] == "Administrador") {
                            echo '
                                    <div style="display: flex; justify-content: flex-end; border: 1px solid #ddd; padding: 10px;">
                                        <a href="excelpagosbanco" class="btn btn-primary" style="background-color: green; margin-left: 10px; color: white; text-decoration: none; padding: 10px;">
                                            <i class="fa fa-upload"></i> 
                                            <i class="fa fa-file-excel-o" aria-hidden="true"> </i>
                                            <i class="fa fa-credit-card-alt">  Poagos de Banco</i>
                                        </a>
                                    </div>
                                ';
                        }
                        ?>



                       <div class="box-body" style="overflow-y:scroll">

                           <table id="tablas2" class="table table-bordered table-striped dt-responsive tablas">
                               <thead>
                                   <tr>
                                       <th style="width:10px">#</th>
                                       <th>CLIENTE</th>
                                       <th>DOCUMENTO</th>
                                       <th>MONTO_ACTUAL</th>
                                       <th hidden>AFAVOR</th>
                                       <th>EFECTIVO</th>

                                       <?php

                                        if ($_SESSION['perfil'] == "SuperAdministrador" || $_SESSION['perfil'] == "Administrador") {

                                            echo '  <th>BANCO</th>';
                                        }
                                        ?>
                                       <th>REPORTE PAGOS</th>
                                       <th>REPORTE GENERAL</th>

                                   </tr>
                               </thead>

                               <tbody>

                                   <?php

                                    if ($_SESSION['perfil'] == "Caja2" || $_SESSION['perfil'] == "Administrador" || $_SESSION['perfil'] == "Caja" || $_SESSION['perfil'] == "Ventas") {


                                        $item = null;


                                        $valor = null;
                                        $item1 = "id";

                                        $valor1 = "idcaja";


                                        $Clientes = ControladorClientes::ctrMostrarClientes($item, $valor);
                                        $caja = ControladorCajas::ctrMostrarCajasmonto($item1, $valor1);
                                        $estadocaja = $caja["estado"];


                                        if ($estadocaja == "desactivo") {
                                            echo '<script>

                                        Swal.fire({
                                            title: "CAJA CERRADA!",
                                            text:"Primero tiene que aperturar caja.",
                                            icon: "warning",
                                            showConfirmButton: true,
                                            confirmButtonText: "Cerrar",
                                            
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                            allowEnterKey: false,
                                            stopKeydownPropagation: false
                                            }).then(function(result){
                                                        if (result.value) {
        
                                                        window.location = "cajas";
        
                                                        }
                                                    })
        
                                        </script>';
                                        }

                                        foreach ($Clientes as $key => $value) {

                                            echo '

                                                <tr>

                                                <td>' . ($key + 1) . '</td>                            
                                                <td>' . $value["nombre"] . '</td>
                                                <td>' . $value["documento"] . '</td>
                                                <td>' . $value["saldo"] . '</td>
                                                <td hidden>' . $value["afavor"] . '</td>';





                                            echo '
                                                 

                                                <td>

                                                    <div class="btn-group">
                                                          <button class="btn btn-primary btnEditarClientePagos " style="background-color:DarkGreen; margin-left: 10px" idCliente="' . $value["id"] . '" data-toggle="modal" data-target="#modalEditarClientePagos">
                                                            <i class="fa fa-money"> S/.Efectivo</i>
                                                            </button>
                                                    </div>                                                    
                                                </td>
                                                  
                                                ';
                                            if ($_SESSION['perfil'] == "SuperAdministrador" || $_SESSION['perfil'] == "Administrador") {
                                                echo '

                                                 <td>
                                                    <div class="btn-group">
                                                         <button class="btn btn-primary btnEditarClientePagosbancos " style="background-color:green; margin-left: 10px" idCliente="' . $value["id"] . '" data-toggle="modal" data-target="#modalEditarClientePagosBancos">
                                                            <i class="fa fa-credit-card-alt"> Banco</i>
                                                            </button>
                                                    </div>                                                    
                                                </td>
                                                
                                            ';
                                            }

                                            echo '

                                            

                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-info btnImprimirFactura" style="background-color:SteelBlue;" codigoVenta="' . $value["id"] . '">
                                                        <i class="fa fa-print"></i> PDF Pagos Nuevos
                                                        </button>
                                                    </div>                                                    
                                                </td>
                                                ';

                                                

                                             
                                                echo '

                                                  <td>
                                                    <div class="btn-group">
                                                        
                                                      <button class="btn btn-warning btnEditarVentasAdmin" idVentas="' . $value["id"] . '">

                                                <i class="fa fa-eye"></i>         
                                                
                                                                                       </button>
                                                    
                                                                                       </div>                                                    
                                                </td>
                                              

                                            ';

                                                echo'
                                                </tr>';
                                        }

                                        
                                    } else {
                                        echo '<script>

                                        Swal.fire({
                                            type: "success",
                                            title: "NO TIENES ACCESO, Reportado (Enviando...)",
                                            showConfirmButton: true,
                                            confirmButtonText: "Cerrar"
                                            }).then(function(result){
                                                        if (result.value) {
            
                                                        window.location = "inicio";
            
                                                        }
                                                    })
            
                                        </script>';
                                    }


                                    ?>


                               </tbody>






                           </table>





                       </div>

                   </div>


               </div>

           </section>

            <script>
                $(document).ready(function() {
                    initDataTable('#tablas2');
                });
            </script>

            <script>
             $(".tablas").on("click", ".btnEditarVentasAdmin", function () {
    
    var idVenta = $(this).attr("idVentas");

   

    window.location = "index.php?ruta=vergeneral&idVenta="+ idVenta;


})

           </script>

       </div>

















       <!--=====================================-=============
=============================-=========================
-======================================================
-========MODAL PARA AGREGAR PAGOS DE LOS CLIENTES======
=======================================================
-======================================================
======================================================-->

       <div id="modalEditarClientePagos" class="modal fade" tabindex="-1" role="dialog" id="ModalCrear" data-backdrop="static" data-keyboard="false">

           <div class="modal-dialog">

               <div class="modal-content">

                   <form role="form" method="post">

                       <!--=====================================
             CABEZA DEL MODAL
             ======================================-->

                       <div class="modal-header" style="background:#008000; color:white">

                           <button type="button" class="close" data-dismiss="modal">&times;</button>

                           <h4 class="modal-title">AGREGAR PAGO</h4>
                           <span style="font-size:80%;">---</span>

                           <div>

                               <input style="background:#008000; color:white; font-size:220%;border:0px;font-weight: bold;" name="montoqueingresaraes" id="montoqueingresaraes" readonly>

                           </div>
                       </div>
                       <input type="text" class="form-control hidden" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>

                       <!--=====================================
             CUERPO DEL MODAL
             ======================================-->

                       <div class="modal-body">

                           <div class="box-body">




                               <!-- MONTO ACTUAL DE LA ULTIMA CAJA Y SU ESTADO  -->

                               <div class="form-group  col-xs-12">

                                   <div class="input-group" style="border: green 5px solid;">

                                       <span class="input-group-addon"><i class="fa fa-exclamation-circle"> Estado de caja</i></span>

                                       <input type="text" class="form-control " id="estadocajapagos"
                                           value="<?php echo $estadocaja;  ?>" name="estadocajapagos" readonly>


                                   </div>

                               </div>



                               <!-- ENTRADA PARA EL NOMBRE -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                       <input type="text" class="form-control input-xs" name="editarCliente2"
                                           id="editarCliente2" readonly required>
                                       <input type="hidden" id="idCliente2" name="idCliente2">
                                       <input type="text" class="form-control input-xs" name="editarDocumentoId2"
                                           id="editarDocumentoId2" readonly required>
                                   </div>

                               </div>


                               <!-- ENTRADA ID 

                    <div class="form-group">

                        <div class="input-group">

                            <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>

                            <input type="text" class="form-control input-lg" name="editarDocumentoId"
                                id="editarDocumentoId" readonly required>

                                <span class="input-group-addon">ID <i class="fa fa-cart-arrow-down"></i></span>


                        </div>

                    </div>-->

                               <!-- ENTRADA TOTAL COMPRAS -->

                               <div class="form-group" hidden>

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>

                                       <input type="text" class="form-control input-xs" name="editarCompras2"
                                           id="editarCompras2" readonly required>

                                       <span class="input-group-addon">TOTAL COMPRAS <i class="fa fa-cart-arrow-down"></i></span>


                                   </div>

                               </div>








                               <!-- SALDO PENDIENTE  -->

                               <div class="form-group  col-lg-6">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-credit-card-alt"> MONTO S/</i></span>

                                       <input type="decimal" class="form-control input-xs" name="editarSaldo2"
                                           id="editarSaldo2" readonly required>


                                   </div>

                               </div>



                               <!-- Nueva A FAVOR-->

                               <div class="form-group col-lg-6" hidden>

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-money">A favor:</i></span>

                                       <input type="decimal" class="form-control input-xs" name="editarAfavor2"
                                           id="editarAfavor2" readonly required>

                                   </div>

                               </div>

                               <!-- Nueva Amortizacion-->

                               <div class="form-group col-lg-6">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-money"> Pagar S/.</i></span>

                                       <input type="decimal" class="form-control input-xs" name="editarNuevaAmortizacion2"
                                           id="editarNuevaAmortizacion2" value="0" required>

                                   </div>

                               </div>






                               <div class="form-group" hidden>

                                   <div class="input-group">

                                       <span class="input-group-addon">A favor esto es para validar lo que viene de bd:</i></span>

                                       <input type="decimal" class="form-control input-lg" name="editarAfavorantiguo2"
                                           id="editarAfavorantiguo2" required>

                                   </div>

                               </div>

                               <!-- Nueva DETALLE-->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-comments"></i></span>

                                       <input type="text" class="form-control input-lg" name="editarNuevaObservacion2"
                                           id="editarNuevaObservacion2" placeholder="ingrese Observacion" required>

                                   </div>

                               </div>


                               <input style="font-size:100%;border:0px;font-weight: bold;" type="text" name="calculofinal" id="calculofinal" title="monto final" readonly>






                           </div>

                       </div>

                       <!--=====================================
             PIE DEL MODAL
             ======================================-->

                       <div class="modal-footer">

                           <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                           <span style="font-size:80%; color:red">------------- </span>

                           <button type="submit" class="btn btn-primary" id="btnGoefectivo" style="background-color:green">Guardar cambios</button>

                       </div>

                   </form>

                   <?php

                    $registrarpagocliente = new ControladorPagos();
                    $registrarpagocliente->ctrRegistrarPagosdeClienteefectivo();

                    ?>

               </div>

           </div>

       </div>






       <!--=====================================-=============
-======================================================
-========MODAL PARA AGREGAR PAGOS DE LOS CLIENTES= BANCOS=====
-======================================================
======================================================-->

       <div id="modalEditarClientePagosBancos" class="modal fade" tabindex="-1" role="dialog" id="ModalCrear" data-backdrop="static" data-keyboard="false">

           <div class="modal-dialog">

               <div class="modal-content">

                   <form role="form" method="post">

                       <!--=====================================
                CABEZA DEL MODAL
                ======================================-->

                       <div class="modal-header" style="background:#008000; color:white">

                           <button type="button" class="close" data-dismiss="modal">&times;</button>

                           <h4 class="modal-title">AGREGAR PAGO BANCOS</h4>

                           <div>

                               <input style="background:#008000; color:white; font-size:220%;border:0px;font-weight: bold;" name="montoqueingresaraesbancos" id="montoqueingresaraesbancos" readonly>

                           </div>
                       </div>

                       <input type="text" class="form-control hidden" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>

                       <!--=====================================
                CUERPO DEL MODAL
                ======================================-->

                       <div class="modal-body">

                           <div class="box-body">

                               <!-- ENTRADA PARA EL NOMBRE -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                       <input type="text" class="form-control input-xs" name="editarCliente2bancos"
                                           id="editarCliente2bancos" readonly required>
                                       <input type="hidden" id="idCliente2bancos" name="idCliente2bancos">
                                       <input type="text" class="form-control input-xs" name="editarDocumentoId2bancos"
                                           id="editarDocumentoId2bancos" readonly required>
                                   </div>

                               </div>



                               <!-- ENTRADA TOTAL COMPRAS -->

                               <div class="form-group" hidden>

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>

                                       <input type="text" class="form-control input-xs" name="editarCompras2bancos"
                                           id="editarCompras2bancos" readonly required>

                                       <span class="input-group-addon">TOTAL COMPRAS <i class="fa fa-cart-arrow-down"></i></span>


                                   </div>

                               </div>

                               <!-- SALDO PENDIENTE  -->

                               <div class="form-group  col-lg-6">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-credit-card-alt"> MONTO ACTUAL</i></span>

                                       <input type="decimal" class="form-control input-xs" name="editarSaldo2bancos"
                                           id="editarSaldo2bancos" readonly required>


                                   </div>

                               </div>



                               <!-- Nueva A FAVOR-->

                               <div class="form-group col-lg-6" hidden>

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-money">A favor:</i></span>

                                       <input type="decimal" class="form-control input-xs" name="editarAfavor2bancos"
                                           id="editarAfavor2bancos" readonly required>

                                   </div>

                               </div>

                               <!-- Nueva Amortizacion-->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-money"> Pagar S/.</i></span>

                                       <input type="decimal" class="form-control input-xs" name="editarNuevaAmortizacion2bancos"
                                           id="editarNuevaAmortizacion2bancos" value="" required>

                                   </div>

                               </div>


                               <div class="form-group" hidden>

                                   <div class="input-group">

                                       <span class="input-group-addon">A favor esto es para validar lo que viene de bd:</i></span>

                                       <input type="decimal" class="form-control input-lg" name="editarAfavorantiguo2bancos"
                                           id="editarAfavorantiguo2bancos" required>

                                   </div>

                               </div>

                               <!-- Nueva DETALLE-->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-comments"></i></span>

                                       <input type="text" class="form-control input-lg" name="editarNuevaObservacion2bancos"
                                           id="editarNuevaObservacion2bancos" placeholder="ingrese Observacion" required>

                                   </div>

                               </div>





                               <input style="font-size:100%;border:0px;font-weight: bold;" type="text" name="calculofinalbanco" id="calculofinalbanco" title="monto final" readonly>



                           </div>

                       </div>

                       <!--=====================================
                PIE DEL MODAL
                ======================================-->

                       <div class="modal-footer">

                           <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                           <span style="font-size:80%; color:red">-----</span>

                           <button type="submit" class="btn btn-primary" id="btnGobanco" style="background-color:green">Guardar cambios</button>

                       </div>

                   </form>

                   <?php

                    $agregarpagobancos = new ControladorPagos();
                    $agregarpagobancos->ctrRegistrarPagosclienteBancos();

                    ?>

               </div>

           </div>

       </div>