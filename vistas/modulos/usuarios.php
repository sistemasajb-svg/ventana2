    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                administrar usuarios

            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> inicio</a></li>

                <li class="active">administrar usuarios</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">




                </div>
                <div class="box-body" hidden>


                    <table class="table table-bordered table-striped dt-responsive tablas" width="100%">

                        <thead>
                            <tr>
                                <th>nombre</th>
                                <th>foto</th>


                            </tr>



                        </thead>

                        <tbody>

                            <?php 

                            $item=null;
                            
                            
                            $valor=null;


                            $usuarios=ControladorUsuarios::ctrMostrarUsuarios($item,$valor);


                            foreach ($usuarios as $key => $value) {

                                echo '

                                   <tr>

                                <td>'.$value["nombre"].'</td>
                                <td><img src="'.$value["foto"].'" width="60px"></td>
                                
                                ';

                               


                                
                            

                            
                                
                                                                                                                                                                                   

                            }
                        
                                                                              
                        ?>


                        </tbody>






                    </table>





                </div>

            </div>


        </section>

    </div>






