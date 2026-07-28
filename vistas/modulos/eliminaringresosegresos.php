       <!-- Content Wrapper. Contains page content -->
       <div class="content-wrapper">
           <!-- Content Header (Page header) -->
           <section class="content-header">
               <h1>
                  Eliminar - Ingreso | Egresos 

               
               </h1>
               <ol class="breadcrumb">
                   <li><a href="#"><i class="fa fa-dashboard"></i> inicio</a></li>

                   <li class="active">Administrar Ingresos Egresos, Solo de la fecha actual</li>
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
                                   <th>TIPO</th>
                                   <th>DNI</th>
                                   <th>PERSONAS</th>
                                   <th>INGRESO</th>
                                   <th>EGRESO</th>
                                   <th>DETALLE PRINCIPAL</th>
                                   <th>DETALLE</th>
                                   <th>FECHA</th>
                                   <th>ELIMINAR PAGO</th>

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
                            


                                        $Clientes=ControladorIngresoegresos::ctrMostrarIngresoSalidaActualEliminar($item,$valor);


                                        foreach ($Clientes as $key => $value) {

                                                echo '

                                                <tr>

                                                <td>'.($key+1).'</td>                            
                                                <td>'.$value["tipo"].'</td>
                                                <td>'.$value["idcliente"].'</td>
                                                <td>'.$value["cliente"].'</td>
                                                <td>'.$value["ingreso"].'</td>
                                                <td>'.$value["salida"].'</td>
                                                <td>'.$value["detalleprincipal"].'</td>
                                                <td>'.$value["detalle"].'</td>
                                                <td>'.$value["fecha"].'</td>
                                                ';

                            
                        
                

                                                echo '<td>

                                              
                                

                                       
                                            <button class="btn btn-danger btnEliminaringresosegresos" idVentas="'.$value["id"].'">


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
Ingreso: (Efectivo retirado de caja) | Egreso: (Efectivo devuelto a caja)


                        <?php

                    $eliminaringresoegreso = new ControladorIngresoegresos();
                    $eliminaringresoegreso -> ctrEliminaringresosegresos();

                        ?>


                   </div>

               </div>


               </div>

           </section>

       </div>







