       <!-- Content Wrapper. Contains page content -->
       <div class="content-wrapper">
           <!-- Content Header (Page header) -->
           <section class="content-header">
               <h1>
                   administrar personas

               </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> inicio</a></li>

                    <li class="active">administrar a Personas</li>
                </ol>
           </section>

           <!-- Main content -->
           <section class="content">

               <!-- Default box -->
               <div class="box">
                   <div class="box-header with-border">


                       <button type="button" class="btn btn-primary" data-toggle="modal"
                           data-target="#modalAgregarPersona">
                           agregar Persona
                       </button>


                   </div>
                   <div class="box-body"style="overflow-y: scroll;">

                       <table id="tablas2" class="table table-bordered table-striped dt-responsive tablas" width="100%">

                           <thead>
                               <tr>
                                   <th style="width:10px">#</th>
                                   <th>NOMBRE</th>
                                   <th>DNI</th>
                                   <th hidden>CORREO</th>
                                   <th>TELEFONO</th>
                                   <th>DIRECCION</th>
                                   <th>CREADO</th>

                                   <th>ACCIONES</th>



                               </tr>



                           </thead>

                           <tbody>

                               <?php 

                            $item=null;
                            
                            
                            $valor=null;

                           

                            


                            $Personas=ControladorPersonas::ctrMostrarPersonas($item,$valor);


                            foreach ($Personas as $key => $value) {

                              




                                echo '

                                   <tr>

                                <td>'.($key+1).'</td>                            
                                <td>'.$value["nombre"].'</td>
                                <td>'.$value["documento"].'</td>
                                <td hidden>'.$value["email"].'</td>
                                <td>'.$value["telefono"].'</td>
                                <td>'.$value["direccion"].'</td>;                                                                                                          
                                <td>'.$value["fechacreacion"].'</td>
                                ';

                            
                        
                

                                echo '<td>

                                    <div class="btn-group">

                                        <button class="btn btn-primary btnEditarPersona" idPersona="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarPersona">

                                            <i class="fa fa-pencil"></i>
                                        </button>


                                        <button class="btn btn-danger btnEliminarPersonaquitar" idPersona="'.$value["id"].'" >


                                            <i class="fa fa-times"></i>
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
MODAL AGREGAR PersonaS
======================================-->
       <div id="modalAgregarPersona" class="modal fade" role="dialog">

           <div class="modal-dialog">

               <div class="modal-content">


                   <form role="form" method="post" enctype="multipart/form-data">

                       <!--=====================================
                    CABEZA DEL MODAL
                    ======================================-->


                       <div class="modal-header" style="background:#3c8dbc; color:white">

                           <button type="button" class="close" data-dismiss="modal">&times;</button>

                           <h4 class="modal-title">Agregar Persona</h4>

                       </div>

                       <!--=====================================
                    CUERPO DEL MODAL
                    ======================================-->

                       <div class="modal-body">
                           <div class="box-body">

                               <!-- ENTRADA PARA EL NOMBRE PERSONA-->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                       <input type="text" class="form-control input-lg" name="nuevoPersona2"
                                           placeholder="Ingresar nombre" required>

                                   </div>

                               </div>

                               <!-- ENTRADA PARA EL DOCUMENTO ID -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-key"></i></span>

                                       <input type="text" min="0" class="form-control input-lg" name="nuevoDocumentoId2"
                                           placeholder="Ingresar documento" required>

                                   </div>

                               </div>

                               <!-- ENTRADA PARA EL EMAIL -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                                       <input type="email" class="form-control input-lg" name="nuevoEmail2"
                                           placeholder="Ingresar email" required>

                                   </div>

                               </div>


                               <!-- ENTRADA PARA EL TELÉFONO -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                                       <input type="text" class="form-control input-lg" name="nuevoTelefono2"
                                           placeholder="Ingresar teléfono" data-inputmask="'mask':'(999) 999-9999'"
                                           data-mask required>

                                   </div>

                               </div>


                               <!-- ENTRADA PARA LA DIRECCIÓN -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

                                       <input type="text" class="form-control input-lg" name="nuevaDireccion2"
                                           placeholder="Ingresar dirección" required>

                                   </div>

                               </div>

                               <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->

                               <div class="form-group" hidden>

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                                       <input type="text" class="form-control input-lg" value="2022-08-00 00:00:00"name="nuevaFechaCreacion2"
                                           placeholder="Ingresar fecha nacimiento"
                                           data-inputmask="'alias': 'yyyy/mm/dd'" data-mask required>

                                   </div>

                               </div>

                           </div>

                       </div>

                       <!--=====================================
                    PIE DEL MODAL
                    ======================================-->

                       <div class="modal-footer">

                           <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                           <button type="submit" class="btn btn-primary">Guardar Persona</button>

                       </div>

                       <?php 

                    $crearPersona=new ControladorPersonas();
                    $crearPersona->ctrCrearPersona();
                    
                    
                    
                    ?>






                   </form>

               </div>
           </div>
       </div>










       <!--=====================================
MODAL EDITAR PersonaS
======================================-->
       <div id="modalEditarPersona" class="modal fade" role="dialog">

           <div class="modal-dialog">

               <div class="modal-content">

                   <form role="form" method="post">

                       <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

                       <div class="modal-header" style="background:#3c8dbc; color:white">

                           <button type="button" class="close" data-dismiss="modal">&times;</button>

                           <h4 class="modal-title">Editar persona</h4>

                       </div>

                       <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

                       <div class="modal-body">

                           <div class="box-body">

                               <!-- ENTRADA PARA EL NOMBRE -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                       <input type="text" class="form-control input-lg" name="editarPersonaeditar"
                                           id="editarPersonaeditar" required>
                                       <input type="hidden" id="idPersona" name="idPersona">
                                   </div>

                               </div>

                               <!-- ENTRADA PARA EL DOCUMENTO ID -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-key"></i></span>

                                       <input type="number" min="0" class="form-control input-lg"
                                           name="editarDocumentoIdeditar" id="editarDocumentoIdeditar" required>

                                   </div>

                               </div>

                               <!-- ENTRADA PARA EL EMAIL -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                                       <input type="email" class="form-control input-lg" name="editarEmaileditar"
                                           id="editarEmaileditar" required>

                                   </div>

                               </div>

                               <!-- ENTRADA PARA EL TELÉFONO -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                                       <input type="text" class="form-control input-lg" name="editarTelefonoeditar"
                                           id="editarTelefonoeditar" data-inputmask="'mask':'(999) 999-9999'" data-mask
                                           required>

                                   </div>

                               </div>

                               <!-- ENTRADA PARA LA DIRECCIÓN -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

                                       <input type="text" class="form-control input-lg" name="editarDireccioneditar"
                                           id="editarDireccioneditar" required>

                                   </div>

                               </div>

                               <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                                       <input type="text" class="form-control input-lg" name="nuevaFechaCreacioneditar"
                                           id="nuevaFechaCreacioneditar" readonly>

                                   </div>

                               </div>

                           </div>

                       </div>

                       <!--=====================================
        PIE DEL MODAL
        ======================================-->

                       <div class="modal-footer">

                           <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                           <button type="submit" class="btn btn-primary">Guardar cambios</button>

                       </div>

                   </form>

                   <?php

        $editarPersona = new ControladorPersonas();
        $editarPersona -> ctrEditarPersona();

      ?>



               </div>

           </div>

       </div>


