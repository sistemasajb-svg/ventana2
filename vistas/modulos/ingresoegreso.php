       <!-- Content Wrapper. Contains page content -->
       <div class="content-wrapper">
           <!-- Content Header (Page header) -->
           <section class="content-header">
               <h1>
                   CONTROL INGRESO & EGRESOS

               </h1>
               <ol class="breadcrumb">
                   <li><a href="#"><i class="fa fa-dashboard"></i> inicio</a></li>

                   <li class="active">Administrar Caja</li>
               </ol>
           </section>
           
           
           <style>
    #mgggessage {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
    }
</style>
<style>
    #mgggessage {
        display: none;
    }
</style>
<div id="mgggessage" style="background-color: #ffcc00; color: #ffffff; padding: 10px; border-radius: 5px; text-align: center;">
    ¡Hace 10 seg. que no usas la página! Se actualizará en <span id="ugggpdateCountdown"></span>.
</div>
<div id="cgggounter" style="font-size: 24px; font-weight: bold; text-align: center; margin-top: 10px;"></div>

<script>
    // Tiempo de inactividad permitido (en milisegundos)
    const IgggNACTIVITY_TIMEOUT = 10000;
    // Tiempo de actualización (en milisegundos)
    const UgggPDATE_INTERVAL = 1000 * 60 * 5; // 2 minutos en milisegundos

    let igggnactiveTimer;
    let ugggpdateTimer;
    let cgggounter = 0;
    let igggsInactive = false;
    let cgggountdownInterval;

    function sggghowInactivemgggessage() {
        if (!igggsInactive) {
            document.getElementById('mgggessage').style.display = 'block';
            igggsInactive = true;
        }
    }

    function hgggideInactivemgggessage() {
        document.getElementById('mgggessage').style.display = 'none';
        igggsInactive = false;
    }

    function rgggesetigggnactiveTimer() {
        clearTimeout(igggnactiveTimer);
        igggnactiveTimer = setTimeout(sggghowInactivemgggessage, IgggNACTIVITY_TIMEOUT);
    }

    function rgggesetugggpdateTimer() {
        clearInterval(ugggpdateTimer);
        clearInterval(cgggountdownInterval);
        ugggpdateTimer = setInterval(ugggpdatePage, UgggPDATE_INTERVAL);
        ugggpdateCountdown(UgggPDATE_INTERVAL / 1000);
    }

    function ugggpdatePage() {
        //alert('¡La página se actualizará en 2 minutos!');
        // Aquí puedes realizar cualquier acción de actualización que necesites
        // Por ejemplo:
        location.reload();
    }

    function ugggpdatecgggounter() {
        cgggounter++;
        //document.getElementById('cgggounter').innerText = `Contador: ${cgggounter} segundos`;
    }

    // Función para actualizar la cuenta regresiva para la próxima actualización
    function ugggpdateCountdown(seconds) {
        let minutes = Math.floor(seconds / 60);
        let remainingSeconds = seconds % 60;
        document.getElementById('ugggpdateCountdown').innerText = `${minutes} min ${remainingSeconds} seg`;
        // Actualiza la cuenta regresiva cada segundo
        cgggountdownInterval = setInterval(function() {
            seconds--;
            minutes = Math.floor(seconds / 60);
            remainingSeconds = seconds % 60;
            document.getElementById('ugggpdateCountdown').innerText = `${minutes} min ${remainingSeconds} seg`;
            if (seconds <= 0) {
                clearInterval(cgggountdownInterval);
            }
        }, 1000);
    }

    // Agrega eventos para detectar actividad del usuario
    function hgggandleUserActivity() {
        if (igggsInactive) {
            hgggideInactivemgggessage();
        }
        rgggesetigggnactiveTimer();
        rgggesetugggpdateTimer();
        cgggounter = 0;
        ugggpdatecgggounter();
    }

    document.addEventListener('mousemove', hgggandleUserActivity);
    document.addEventListener('keypress', hgggandleUserActivity);

    // Inicia el temporizador de inactividad y el temporizador de actualización
    rgggesetigggnactiveTimer();
    rgggesetugggpdateTimer();
    ugggpdatecgggounter();
</script>

            <?php
            // Inicializa las fechas con valores predeterminados o con valores del formulario si est�� presente
            $fecha1 = isset($_POST['fecha1']) ? $_POST['fecha1'] : date('Y-m-d');

            // Subtract 1 day from $fecha1
            $nuevaFecha = date('Y-m-d', strtotime($fecha1));

             $fecha2 = isset($_POST['fecha2']) ? $_POST['fecha2'] : date('Y-m-d');
$fecha2_mas_1_dia = date('Y-m-d', strtotime($fecha2 . ' + 1 day'));

// Now $fecha2_mas_1_dia contains the date $fecha2 incremented by one day.


            ?>

           <!-- Main content -->
           <section class="content">

               <!-- Default box -->
               <div class="div_contenedor">
                   <div class="div_centrado">





                       <table class="table table-bordered table-striped dt-responsive tablas">

                           <thead>
                               <tr >
                                   <th style="width:10px"></th>

                                   <th style="width:100px"></th>
                                   <th style="width:100px"></th>




                               </tr>



                           </thead>

                           <tbody>

                                <?php

                                    if ($_SESSION['perfil']=="Caja2" || $_SESSION['perfil']=="Administrador" || $_SESSION['perfil']=="Caja" || $_SESSION['perfil']=="Ventas") {


                                        $item=null;
                                            
                                            
                                        $valor=null;
                                        
                                        $item1="id";
                                                                                        
                                        $valor1="idcaja";

                                    

                            $caja=ControladorCajas::ctrMostrarCajasmonto($item1,$valor1);
                                        $estadocaja=$caja["estado"];


                                if($estadocaja == "desactivo"){
                                    echo'<script>

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
        
                                        </script>';}





                                                echo '

                                                <tr>

                                                <td></td>                            
                                                ';
                                                  
                                                echo '
                                                    <td>

                                                        <div class="btn-group">
                                                            <button class="btn btn-primary btn btn-success btnValidarClientePagos" data-toggle="modal" data-target="#modalingresocaja">
                                                                <i class="fa fa-plus"> Ingreso</i>
                                                            </button>                                                           
                                                        
                                                        </td>
                                                                                            
                                                        <td>
                                                            <div class="btn-group">
                                                            <button class="btn btn-primary btnValidarClientePagos btn btn-warning" data-toggle="modal" data-target="#modalegresocaja">
                                                            <i class="fa fa-minus"> Egreso</i>
                                                            </button>
                                                        </div>        

                                                    </td>

                                                </tr> ';
                                
                                                                                                                                                                                   

                                    }
                        
                                                                              
                                ?>


                           </tbody>




                         


                       </table>





               </div>






<script>
jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selector').select2();
    });
});
</script>

<script>
jQuery(document).ready(function($){
    // Inicializa Select2 en el elemento con clase 'mi-selector'
    $('.mi-wselector').select2();
});
</script>

               


               </div>





                 <!-- Default box -->
                 <div class="box">
                   <div class="box-header with-border">


                   <div class="box-body"  style="overflow-y:scroll">


                            <form action="" method="post">
                               <label for="fecha1">FECHA INICIAL:</label>
                               <input type="date" id="fecha1" name="fecha1" value="<?= htmlspecialchars($fecha1) ?>">

                               <label for="fecha2">FECHA FINAL:</label>
                               <input type="date" id="fecha2" name="fecha2" value="<?= htmlspecialchars($fecha2) ?>">

                               <input type="submit" value="MOSTRAR">
                           </form>


                       <table id="tablas2"class="table table-bordered table-striped dt-responsive tablas">

                           <thead>
                               <tr>
                                   <th style="width:10px">#</th>
                                   <th>CLIENTE</th>
                                   <th>DNI</th>
                                   <th>TIPO</th>
                                   <th>INGRESO</th>
                                   <th>SALIDA</th>
                                   <th>DETALLE PRINCIPAL</th>
                                   <th>DETALLADO</th>
                                   <th>ESTADO</th>
                                   <th>FECHA</th>
                                   <th>TICKET</th>
                             </tr>

                           </thead>

                           <tbody>

                                <?php

                                    if ($_SESSION['perfil']=="Caja2" || $_SESSION['perfil']=="Administrador" || $_SESSION['perfil']=="Caja" || $_SESSION['perfil']=="Ventas") {

                                        $item=null;                                            
                                            
                                        $valor=null;                                    

                                        $item1="id";
                                                                                        
                                        $valor1="idcaja";

                                        $Clientes = ControladorIngresoegresos::ctrfiltrarcajaingresosalida($item, $valor, $fecha1, $fecha2_mas_1_dia);
                                        $caja=ControladorCajas::ctrMostrarCajasmonto($item1,$valor1);
                                        $montocaja=$caja["caja"];
                                        $estadocaja=$caja["estado"];

                                        foreach ($Clientes as $key => $value) {

                                                echo '

                                                <tr>

                                                <td>'.($key+1).'</td>                            
                                                <td>'.$value["cliente"].'</td>
                                                <td>'.$value["dni"].'</td>
                                                <td>'.$value["tipo"].'</td>
                                                <td>'.$value["ingreso"].'</td>
                                                <td>'.$value["salida"].'</td>
                                                <td>'.$value["detalleprincipal"].'</td>
                                                <td>'.$value["detalle"].'</td>
                                                <td>'.$value["estado"].'</td>
                                                <td>'.$value["fecha"].'</td>
                                                ';

                            
                        
                

                                                echo '<td>

                                              
                                            <button class="btn btn-success btnImprimirTicketcaja" codigoVenta="'.$value["id"].'">

                                                <i class="fa fa-print"> Ticket Nº '.$value["id"].'</i>

                                            </button>

                                      
                                        

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


           </section>




       </div>



       <style>
    /*Reseteamos el margen de html y body*/
    html,body{ margin: 0;}
    /* declaramos un color y una altura full*/
    .div_contenedor{
        display: flex;
  justify-content: center;
    }
    /* declaramos un color, un ancho y una altura*/
    .div_centrado{
    
        margin: 0 auto;
    }
</style>















<div id="modalingresocaja" class="modal fade"  role="dialog" id="ModalCrear" data-backdrop="static" data-keyboard="false" >


    <div class="modal-dialog">

        <div class="modal-content">

            <form role="form" method="post" enctype="multipart/form-data">

                <!--=====================================
                CABEZA DEL MODAL
                ======================================-->

                <div class="modal-header"  style="background:#008000; color:white">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title">Ingreso Caja</h4>
                    <input type="decimal" class="form-control input-lg" style="background-color:green; border:0; color: #ffffff;width:200px;height:35px" id="montodecimal"
                                name="montodecimal"  value="" readonly>

                </div>

                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->

                <div class="modal-body">

                    <div class="box-body">


                       
                



                        <!-- MONTO ACTUAL DE LA ULTIMA CAJA Y SU ESTADO  -->

                        <div class="form-group  col-xs-6" >

                            <div class="input-group" style="border: green 5px solid;">

                                <span class="input-group-addon"><i class="fa fa-credit-card-alt"> Monto en caja</i></span>

                                <input type="text" class="form-control " id="montocajaingreso"
                                        value="<?php echo $montocaja;  ?>" name="montocajaingreso" readonly>

                            </div>

                        </div>

                        
                        <!-- MONTO ACTUAL DE LA ULTIMA CAJA Y SU ESTADO  -->

                        <div class="form-group  col-xs-6" >

                            <div class="input-group" style="border: green 5px solid;">

                                <span class="input-group-addon"><i class="fa fa-exclamation-circle"> Estado de caja</i></span>

                                <input type="text" class="form-control " id="estadocaja"
                                        value="<?php echo $estadocaja;  ?>" name="estadocaja" readonly>


                            </div>

                        </div>



                         <!--=====================================
                            ENTRADA DEL CLIENTE
                            ======================================-->

                                <div class="form-group col-xs-12">

                                    <div class="input-group">

                                        <span class="input-group-addon"><i class="fa fa-users"></i></span>

                                        <select class="form-control mi-selector" style="width:100%" id="seleccionarpersonaingreso" name="seleccionarpersonaingreso"
                                            required>

                                            <option value="">Seleccionar Persona</option>

                                            <?php 


                                            $item=null;
                                            $valor=null;

                                            $clientes=ControladorPersonas::ctrMostrarPersonas($item,$valor);

                                            foreach ($clientes as $key => $value) {

                                            echo ' <option value="'.$value["documento"].'">'.$value["nombre"].'</option>';

                                            }


                                            ?>




                                        </select>

                                    </div>

                                </div>




                        <!-- ENTRADA PARA EL MONTO -->

                        <div class="form-group col-xs-12">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-money"> S/.</i></span>

                                <input type="decimal" class="form-control input-lg" id="ingresomontoingreso"
                                name="ingresomontoingreso"  placeholder="Ingrese monto*" value="" required>

                            </div>

                        </div>

                                 



                        <!-- ENTRADA PARA SELECCIONAR SU DETALLE PRINCIPAL -->

                        <div class="form-group col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                                <input type="text" class="form-control input-lg" id="detalleprincipalingreso"
                                name="detalleprincipalingreso"  placeholder="Ingrese detalle principal*" value="" required>
                            </div>                       
                        </div>

                        
                        <!-- ENTRADA PARA SELECCIONAR SU DETALLE PRINCIPAL -->

                        <div class="form-group col-xs-12" hidden>
                            <div class="input-group">
                                <span class="input-group-addon">calculando nuevo caja total</i></span>
                                <input type="text" class="form-control input-lg" id="nuevomontoactualdecaja"
                                name="nuevomontoactualdecaja"  placeholder="monto actual de caja" value="" required>
                            </div>                       
                        </div>



                        <!-- ENTRADA PARA SELECCIONAR SU PERFIL -->

                        <div class="form-group col-xs-12" >
                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                                <input type="text" class="form-control input-lg" id="detalleingreso"
                                name="detalleingreso"  placeholder="Ingrese detalle*" value="" required>
                            </div>                       
                        </div>




                        
                        <!-- ENTRADA PARA VERIFICAR O NO -->

                        <div class="form-group col-xs-12" hidden>

                            <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-hourglass-start"></i></span>

                                    <select class="form-control" id="estadoingreso" name="estadoingreso" required>
                                        <option value="ingresoterminado">Seleccione estado de Ingreso*</option>
                                        <option value="ingresoenproceso">En proceso</option>
                                        <option value="ingresoterminado">Confirmado</option>
                                    </select>

                            </div>

                        </div>



                        <!-- ENTRADA PARA SUBIR FOTO -->

                        <div class="form-group">

                            <div class="panel"></div>

                            
                            </div>

                        </div>
                    </div>

                    <!--=====================================
                    PIE DEL MODAL
                    ======================================-->

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                        <button type="submit" class="btn btn-primary" id="btnGoingresocaja">Guardar Ingreso</button>

                    </div>

                <?php
                
               $ingreesocaja=new ControladorIngresoegresos();
               $ingreesocaja->ctrCrearIngresoPersonaacaja();
                
                
                ?>

            </form>
        </div>
    </div>
</div>











<!--========================EGRESOS=====================================-->


<div id="modalegresocaja" class="modal fade"  role="dialog" id="ModalCrear" data-backdrop="static" data-keyboard="false" >


    <div class="modal-dialog">

        <div class="modal-content">

            <form role="form" method="post" enctype="multipart/form-data">

                <!--=====================================
                CABEZA DEL MODAL
                ======================================-->

                <div class="modal-header"  style="background:#ffcc00; color:black">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title">Egreso Caja</h4>
                     <input type="decimal" class="form-control input-lg" style="background-color:#ffcc00; border:0; color:black;width:200px;height:35px" id="montodecimal2"
                                name="montodecimal2"  value="" readonly>


                </div>

                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->

                <div class="modal-body">

                    <div class="box-body">




                                            
                        


                        <!-- MONTO ACTUAL DE LA ULTIMA CAJA Y SU ESTADO  -->

                        <div class="form-group  col-xs-6" >

                            <div class="input-group" style="border: green 5px solid;">

                                <span class="input-group-addon"><i class="fa fa-credit-card-alt"> Monto en caja</i></span>

                                <input type="text" class="form-control "  id="montocajaegreso"
                                        value="<?php echo $montocaja;  ?>" name="montocajaegreso" readonly>

                            </div>

                        </div>

                        

                        
                        <!-- MONTO ACTUAL DE LA ULTIMA CAJA Y SU ESTADO  -->

                        <div class="form-group  col-xs-6" >

                            <div class="input-group" style="border: green 5px solid;">

                                <span class="input-group-addon"><i class="fa fa-exclamation-circle"> Estado de caja</i></span>

                                <input type="text" class="form-control " id="estadocajaegreso"
                                        value="<?php echo $estadocaja;  ?>" name="estadocajaegreso" readonly>


                            </div>

                        </div>
                    
                                <!--=====================================
                            ENTRADA DE PERSONA
                            ======================================-->

                                <div class="form-group ">

                                    <div class="input-group">

                                        <span class="input-group-addon "><i class="fa fa-users"></i></span>

                                        <select class="form-control mi-wselector" style="width:100%" id="seleccionarpersonaegresso" name="seleccionarpersonaegresso"
                                            required>

                                            <option value="">Seleccionar Persona</option>

                                            <?php 


                                            $item=null;
                                            $valor=null;

                                            $clientes=ControladorPersonas::ctrMostrarPersonas($item,$valor);

                                            foreach ($clientes as $key => $value) {

                                            echo ' <option dnisalida="'.$value["documento"].'" value="'.$value["documento"].'">'.$value["nombre"].'</option>';

                                            }


                                            ?>




                                        </select>

                                    </div>

                                </div>


                        <!-- ENTRADA PARA EL MONTO -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-money"></i></span>

                                <input type="text" class="form-control input-lg" id="ingresoMontosegreso"
                                name="ingresoMontosegreso"  placeholder="Ingrese monto de egreso" value="" required>

                            </div>

                        </div>





                        <!-- ENTRADA PARA SELECCIONAR SU DETALLE SALIDA -->

                        <div class="form-group">
                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                                <input type="text" class="form-control input-lg" id="detalleprincipalegreso"
                                name="detalleprincipalegreso"  placeholder="Ingrese motivo principal*" value="" required>
                            </div>                       
                        </div>

                        <!-- ENTRADA PARA SELECCIONAR SU DETALLE PRINCIPAL -->

                        <div class="form-group col-xs-12" hidden>
                            <div class="input-group">
                                <span class="input-group-addon">calculando nuevo caja total salida</i></span>
                                <input type="text" class="form-control input-lg" id="nuevomontoactualdecajasalida"
                                name="nuevomontoactualdecajasalida"  placeholder="monto actual de caja salida" value="" required>
                            </div>                       
                        </div>



                        <!-- ENTRADA PARA SELECCIONAR SU DETALLE SALIDA -->

                        <div class="form-group">
                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-comment-o"></i></span>
                                <input type="text" class="form-control input-lg" id="detalleegreso"
                                name="detalleegreso"  placeholder="Ingrese detalle de salida" value="" required>
                            </div>                       
                        </div>


                        <!-- ENTRADA PARA VERIFICAR O NO -->

                        <div class="form-group">

                            <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-hourglass-start"></i></span>

                                    <select class="form-control" id="estadoegreso" name="estadoegreso" required>
                                        <option value="">Seleccione estado de salida*</option>
                                        <option value="salidaenproceso">En proceso</option>
                                        <option value="Salidaterminada">Salida confirmada</option>
                                    </select>

                            </div>

                        </div>




                        <div class="form-group">

                            <div class="panel"></div>

                            
                            </div>

                        </div>
                    </div>

                    <!--=====================================
                    PIE DEL MODAL
                    ======================================-->

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                        <button type="submit" class="btn btn-primary" id="btnGoegresocaja">Guardar Egreso</button>

                    </div>

                <?php
                
            $egresocaja=new ControladorIngresoegresos();
            $egresocaja->ctrCrearEgresoPersonaacaja();
                
                
                ?>

            </form>
        </div>
    </div>
</div>

