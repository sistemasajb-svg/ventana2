       <!-- Content Wrapper. Contains page content -->
       <div class="content-wrapper">
           <!-- Content Header (Page header) -->
           <section class="content-header">
               <h1>
                   administrar pendientes

               </h1>
               <ol class="breadcrumb">
                   <li><a href="#"><i class="fa fa-dashboard"></i> inicio</a></li>

                   <li class="active">administrar Pendientes</li>
               </ol>
           </section>

           <!-- Main content -->
           <section class="content">

               <!-- Default box -->
               <div class="box">
                   <div class="box-header with-border">


                      


                   </div>
                   <div class="box-body" style="overflow-y: scroll;">

<script>
    $(document).ready(function() {
        $('.tablas').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"
            }
        });
    });
</script>
                       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">

                           <thead>
                               <tr>
                                   <th hidden style="width:10px">#</th>
                                   <th>ID</th>
                                   <th>CLIENTE</th>
                                   <th>DOCUMENTO</th>
                                   <th>TIPO</th>
                                   <th>ESTADO</th>
                                   <th>MOTIVO</th>
                                   <th>DETALLE</th>
                                   <th>FECHA</th>

                                   <th>Acciones</th>



                               </tr>



                           </thead>

                           <tbody>

                               <?php 

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
                            


                            $Pendientes=ControladorPendientes::ctrMostrarPendientes($item,$valor);


                            foreach ($Pendientes as $key => $value) {

                              




                                echo '

                                   <tr>

                                <td hidden>'.($key+1).'</td>                            
                                <td>'.$value["id"].'</td>
                                <td>'.$value["cliente"].'</td>
                                <td>'.$value["dni"].'</td>
                                <td>'.$value["tipo"].'</td>
                                <td>'.$value["estado"].'</td>
                                <td>'.$value["detalleprincipal"].'</td>
                                <td>'.$value["detalle"].'</td>
                                <td>'.$value["fecha"].'</td>
                                ';

                            
                        
                

                                echo '<td>

                                    <div class="btn-group">

                                        <button class="btn btn-primary btnEditarPendiente" idPendiente="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarPendiente">

                                            <i class="fa fa-plus"></i>
                                        </button>



                                      

                                    </div>
                                    
                                    <div class="btn-group">

                                        <button class="btn btn-primary btnEditarPendienteegreso" idPendiente2="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarPendienteegreso">

                                            <i class="fa fa-minus"></i>
                                        </button>


                                      

                                    </div>
                                    

                                </td>

                            </tr> ';
                                
                                                                                                                                                                                   

                            }
                        
                                                                              
                        ?>


                           </tbody>






                       </table>





                   </div>

               </div>


           </section>

       </div>

















       <!--=====================================
        MODAL EDITAR PendienteS
        ======================================-->
       <div id="modalEditarPendiente" class="modal fade" role="dialog">

           <div class="modal-dialog">

               <div class="modal-content">

                   <form role="form" method="post">

                       <!--=====================================
                        CABEZA DEL MODAL
                        ======================================-->

                                    <div class="modal-header" style="background:#008000; color:white">

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                                        <h4 class="modal-title">Devolución a caja y cerrar - INGRESO</h4>

                                    </div>

                                    <!--=====================================
                        CUERPO DEL MODAL
                        ======================================-->

                                    <div class="modal-body">

                                        <div class="box-body">

                                            <!-- ENTRADA PARA EL NOMBRE -->

                                            <div class="form-group" hidden>

                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                                    <input type="text" class="form-control input-lg" name="editarPendiente"
                                                        id="editarPendiente" required readonly>
                                                    <input type="hidden" id="idPendiente" name="idPendiente">
                                                </div>

                                            </div>


                                                <!-- ENTRADA PARA TIPO -->

                                            <div class="form-group col-xs-12">

                                                <div class="input-group">

                                                    <span class="input-group-addon">Tipo</span>

                                                    <input type="text" class="form-control input-xs" name="editarTipopendiente"
                                                        id="editarTipopendiente" required readonly>

                                                </div>

                                            </div>




                                            <!-- detalle editarnombrecliente -->

                                            <div class="form-group col-xs-8">

                                                <div class="input-group">

                                                    <span class="input-group-addon">CLIENTE</i></span>

                                                    <input type="text" class="form-control input-xs" name="editarnombrecliente"
                                                        id="editarnombrecliente" required readonly>

                                                </div>

                                            </div>




                                                    <!-- detalle editarnombrecliente -->

                                                <div class="form-group col-xs-4">

                                                    <div class="input-group">

                                                        <span class="input-group-addon">DNI</i></span>

                                                        <input type="text" class="form-control input-xs" name="editardnicliente"
                                                            id="editardnicliente" required readonly>

                                                    </div>

                                                </div>





                                                <!-- detalle editarnombrecliente -->

                                            <div class="form-group " hidden>

                                                <div class="input-group">

                                                    <span class="input-group-addon">ID</i></span>

                                                    <input type="text" class="form-control input-xs" name="id"
                                                        id="id" required readonly>

                                                </div>

                                            </div>

                                            <!-- ENTRADAINGRESO -->

                                            <div class="form-group col-xs-6">

                                                <div class="input-group">

                                                    <span class="input-group-addon">S/. Ingreso</i></span>

                                                    <input type="text" class="form-control input-xs" name="editarIngresoMontopendiente"
                                                        id="editarIngresoMontopendiente" required readonly>

                                                </div>

                                            </div>


                                            <!-- ENTRADAINGRESO -->

                                            <div class="form-group col-xs-6">

                                                <div class="input-group">

                                                    <span class="input-group-addon">S/. Salida</i></span>

                                                    <input type="text" class="form-control input-xs" name="editarsalidaMontopendiente"
                                                        id="editarsalidaMontopendiente" required readonly>

                                                </div>

                                            </div>


                                            <!-- detalle principal -->

                                            <div class="form-group col-xs-12">

                                                <div class="input-group">

                                                    <span class="input-group-addon">Motivo</i></span>

                                                    <input type="text" class="form-control input-xs" name="editardetalleprincipal"
                                                        id="editardetalleprincipal" required readonly>

                                                </div>

                                            </div>

                                            

                                            <!-- detalle principal -->

                                            <div class="form-group col-xs-12">

                                                <div class="input-group">

                                                    <span class="input-group-addon">Detalle</i></span>

                                                    <input type="text" class="form-control input-lg" style="font-size: 12px" name="editardetallesegundo"
                                                        id="editardetallesegundo" required>

                                                </div>

                                            </div>

                                            
                                        





                                            <div class="form-group col-xs-12">

                                                <div class="input-group">

                                                    <span class="input-group-addon">Cantidad S/.</i></span>

                                                    <input type="text" class="form-control input-lg" style="font-size: 12px" name="cantidadingresopendienteagregar"
                                                        id="cantidadingresopendienteagregar" required>

                                                </div>

                                            </div>




                                            <!-- ENTRADA PARA VERIFICAR O NO -->

                                            <div class="form-group col-xs-12" hidden>

                                                <div class="input-group">

                                                        <span class="input-group-addon"><i class="fa fa-hourglass-start"></i></span>

                                                        <select class="form-control" id="estadopendientes" name="estadopendientes" required>
                                                            <option value="null">Seleccione estado*</option>
                                                            <option value="enProceso">En proceso</option>
                                                            <option value="Terminado">Terminado</option>
                                                        </select>

                                                </div>

                                            </div>



                                        </div>

                                    </div>

                                    <!--=====================================
                        PIE DEL MODAL
                        ======================================-->

                       <div class="modal-footer">

                           <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                           <button type="submit" class="btn btn-primary">INGRESO A CAJA</button>

                       </div>

                   </form>

                    <?php

                        $editarPendiente = new ControladorPendientes();
                        $editarPendiente -> ctrEditarPendiente();

                    ?>



               </div>

           </div>

       </div>



          




       <!--=====================================
MODAL EDITAR PendienteS
======================================-->
<div id="modalEditarPendienteegreso" class="modal fade" role="dialog">

    <div class="modal-dialog">

        <div class="modal-content">

            <form role="form" method="post">

                <!--=====================================
                CABEZA DEL MODAL
                ======================================-->

                <div class="modal-header" style="background:#696969; color:white">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title">Diferencia por compras -EGRESO</h4>

                </div>

                            <!--=====================================
                CUERPO DEL MODAL
                ======================================-->

                <div class="modal-body">

                    <div class="box-body">

                        <!-- ENTRADA PARA EL NOMBRE -->

                        <div class="form-group" hidden>

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                <input type="text" class="form-control input-lg" name="editarPendienteegreso"
                                    id="editarPendienteegreso" required readonly>
                                <input type="TEXT" id="idPendienteegreso" name="idPendienteegreso">
                            </div>

                        </div>


                        <!-- ENTRADA PARA TIPO -->

                        <div class="form-group col-xs-12">

                            <div class="input-group">

                                <span class="input-group-addon">Tipo</span>

                                <input type="text" class="form-control input-xs" name="editarTipopendienteegreso"
                                    id="editarTipopendienteegreso" required readonly>

                            </div>

                        </div>




                    <!-- detalle editarnombrecliente -->

                        <div class="form-group col-xs-8">

                            <div class="input-group">

                                <span class="input-group-addon">CLIENTE</i></span>

                                <input type="text" class="form-control input-xs" name="editarnombreclienteegreso"
                                    id="editarnombreclienteegreso" required readonly>

                            </div>

                        </div>




                            <!-- detalle editarnombrecliente -->

                        <div class="form-group col-xs-4">

                            <div class="input-group">

                                <span class="input-group-addon">DNI</i></span>

                                <input type="text" class="form-control input-xs" name="editardniclienteegreso"
                                    id="editardniclienteegreso" required readonly>

                            </div>

                        </div>





                        <!-- detalle editarnombrecliente -->

                        <div class="form-group " hidden>

                            <div class="input-group">

                                <span class="input-group-addon">ID</i></span>

                                <input type="text" class="form-control input-xs" name="idegreso"
                                    id="idegreso" required readonly>

                            </div>

                        </div>

                    <!-- ENTRADAINGRESO -->

                        <div class="form-group col-xs-6">

                            <div class="input-group">

                                <span class="input-group-addon">S/. Ingreso</i></span>

                                <input type="text" class="form-control input-xs" name="editarIngresoMontopendienteegreso"
                                    id="editarIngresoMontopendienteegreso" required readonly>

                            </div>

                        </div>


                        <!-- ENTRADAINGRESO -->

                        <div class="form-group col-xs-6">

                            <div class="input-group">

                                <span class="input-group-addon">S/. Salida</i></span>

                                <input type="text" class="form-control input-xs" name="editarsalidaMontopendienteegreso"
                                    id="editarsalidaMontopendienteegreso" required readonly>

                            </div>

                        </div>


                        <!-- detalle principal -->

                        <div class="form-group col-xs-12">

                            <div class="input-group">

                                <span class="input-group-addon">Motivo</i></span>

                                <input type="text" class="form-control input-xs" name="editardetalleprincipalegreso"
                                    id="editardetalleprincipalegreso" required readonly>

                            </div>

                        </div>

                        

                        <!-- detalle principal -->

                        <div class="form-group col-xs-12">

                            <div class="input-group">

                                <span class="input-group-addon">Detalle</i></span>

                                <input type="text" class="form-control input-lg" style="font-size: 12px" name="editardetallesegundoegreso"
                                    id="editardetallesegundoegreso" required>

                            </div>

                        </div>

                    
                





                    <div class="form-group col-xs-12">

                            <div class="input-group">

                                <span class="input-group-addon">Cantidad S/.</i></span>

                                <input type="text" class="form-control input-lg" style="font-size: 12px" name="cantidadingresopendienteagregaregreso"
                                    id="cantidadingresopendienteagregaregreso" required>

                            </div>

                    </div>




                    <!-- ENTRADA PARA VERIFICAR O NO -->

                    <div class="form-group col-xs-12" hidden>

                        <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-hourglass-start"></i></span>

                                <select class="form-control" id="estadopendientesegreso" name="estadopendientesegreso" required>
                                    <option value="null">Seleccione estado*</option>
                                    <option value="enProceso">En proceso</option>
                                    <option value="Terminado">Terminado</option>
                                </select>

                        </div>

                    </div>



                    </div>

                </div>

                <!--=====================================
                PIE DEL MODAL
                ======================================-->

                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                    <button type="submit" class="btn btn-primary">EGRESO DE CAJA</button>

                </div>

            </form>

            <?php

            $editarPendiente = new ControladorPendientes();
            $editarPendiente -> ctrEditarPendienteegreso();

            ?>



        </div>

    </div>

</div>
