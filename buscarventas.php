<?php 


require_once "controladores/ventas.controlador.php";
require_once "modelo/ventas.modelo.php";



    // Verificar si se han enviado las fechas desde el formulario
    if (isset($_POST['fechaInicial']) && isset($_POST['fechaFinal'])) {
        $fechaInicial = $_POST['fechaInicial'];
        $fechaFinal = $_POST['fechaFinal'];

        // Aquí deberías realizar la consulta a tu base de datos para obtener las ventas filtradas por fecha
        // Utiliza tus métodos y controladores para obtener los datos necesarios y llenar la tabla
        $respuesta = ControladorVerventas::ctrVentasporfecha($fechaInicial, $fechaFinal);





                                if ($_SESSION['perfil']=="SuperAdministrador" || $_SESSION['perfil']=="Administrador" || $_SESSION['perfil']=="Caja"|| $_SESSION['perfil']=="Ventas") {




                                    if(isset($_GET["fechaInicial"])){

                                        $fechaInicial=$_GET["fechaInicial"];
                                        $fechaFinal=$_GET["fechaFinal"];



                                    }else{


                                        $fechaInicial=null;
                                                                
                                                                
                                        $fechaFinal=null;


                                    }

                                    $respuesta=ControladorVerventas::ctrVentasporfecha($fechaInicial,$fechaFinal);



                        



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

 } else {
        // Si no se han enviado las fechas, puedes mostrar un mensaje o redirigir al formulario
        echo '<tr><td colspan="8">No se han proporcionado fechas para filtrar.</td></tr>';
    }
?>
