<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            PAGOS DEL DIA 

        <?php 
            $DateAndTime = date('m-d-Y');  
            echo "PAGOS DEL DIA   : $DateAndTime.";
        ?>

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> inicio</a></li>

            <li class="active">Administrar Pagos</li>
        </ol>

    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">

                <div class="box-body"  style="overflow-y:scroll">
                    
                    <form action="pagos" method="post" style="float: right">
                        <button type="submit">
                            <i class="fa fa-arrow-left"></i> Ir a pagos
                        </button>
                    </form>

                    <table id="tablas2"class="table table-bordered table-striped dt-responsive tablas">

                        <thead>
                            <tr>
                                   <th style="width:10px">#</th>
                                   <th>CLIENTE</th>
                                   <th>DNI</th>
                                   <th>CANTIDAD</th>
                                   <th>AFAVOR</th>
                                   <th>DETALLE</th>
                                   <th>FECHA</th>
                                   <th>TICKET</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                                if ($_SESSION['perfil']=="Caja2" || $_SESSION['perfil']=="Administrador" || $_SESSION['perfil']=="Caja" || $_SESSION['perfil']=="Ventas") {


                                    $item=null;
                                            
                                            
                                    $valor=null;

                                    $Clientes=ControladorPagos::ctrMostrarHistorialpagos($item,$valor);


                                        foreach ($Clientes as $key => $value) {

                                                echo '

                                                <tr>

                                                <td>'.($key+1).'</td>                            
                                                <td>'.$value["cliente"].'</td>
                                                <td>'.$value["dni"].'</td>
                                                <td>'.$value["cantidad"].'</td>
                                                <td>'.$value["afavor"].'</td>
                                                <td>'.$value["detalle"].'</td>
                                                <td>'.$value["fecha"].'</td>
                                                ';


                                                echo '<td>

                                              
                                            <button class="btn btn-success btnImprimirTicket" codigoVenta="'.$value["id"].'">

                                                <i class="fa fa-print">Ticket</i>

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


        </div>

    </section>

</div>

<script>
    $(document).ready(function() {
        initDataTable('#tablas2');
    });
</script>







