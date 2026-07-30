       <!-- Content Wrapper. Contains page content -->
       <div class="content-wrapper">
           <!-- Content Header (Page header) -->
           <section class="content-header">
               <h1>
                  Eliminar -Pagos de clientes 

               
               </h1>
               <ol class="breadcrumb">
                   <li><a href="#"><i class="fa fa-dashboard"></i> inicio</a></li>

                   <li class="active">Administrar Pagos, Solo de la fecha actual</li>
               </ol>
           </section>

           <!-- Main content -->
           <section class="content">

               <!-- Default box -->
               <div class="box">
                   <div class="box-header with-border">








                   <div class="box-body"  style="overflow-y:scroll">




                       <table id="tablas2"class="table table-bordered table-striped dt-responsive tablas">

                           <thead>
                               <tr>
                                   <th style="width:10px">#</th>
                                   <th>TIPO PAGO</th>
                                   <th>CLIENTE</th>
                                   <th>DNI</th>
                                   <th>CANTIDAD</th>
                                   <th>AFAVOR</th>
                                   <th>DETALLE</th>
                                   <th>FECHA</th>
                                   <th>ELIMINAR PAGO</th>



                               </tr>



                           </thead>

                           <tbody>

                                <?php

                                    if ($_SESSION['perfil']=="SuperAdministrador" || $_SESSION['perfil']=="Administrador") {


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
                            


                                        $Clientes=ControladorPagos::ctrMostrarHistorialpagos($item,$valor);


                                        foreach ($Clientes as $key => $value) {

                                                echo '

                                                <tr>

                                                <td>'.($key+1).'</td>                            
                                                <td>'.$value["metodopago"].'</td>
                                                <td>'.$value["cliente"].'</td>
                                                <td>'.$value["dni"].'</td>
                                                <td>'.$value["cantidad"].'</td>
                                                <td>'.$value["afavor"].'</td>
                                                <td>'.$value["detalle"].'</td>
                                                <td>'.$value["fecha"].'</td>
                                                ';

                            
                        
                

                                                echo '<td>

                                              
                                

                                       
                                            <button class="btn btn-danger btnEliminarPagos" idVentas="'.$value["id"].'">


                                            <i class="fa fa-times"> Eliminar pago</i>
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



                        <?php

                        $eliminarpagos = new ControladorPagos();
                        $eliminarpagos -> ctrEliminarPagos();

                        ?>


                   </div>

               </div>


               </div>

           </section>

        </div>

<script>
    $(document).ready(function() {
        initDataTable('#tablas2');
    });
</script>






