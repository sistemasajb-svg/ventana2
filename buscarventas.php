<?php

require_once "controladores/clientes.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/verventas.controlador.php";

require_once "modelo/clientes.modelo.php";
require_once "modelo/usuarios.modelo.php";
require_once "modelo/verventas.modelo.php";

if (isset($_POST['fechaInicial']) && isset($_POST['fechaFinal'])) {
    $fechaInicial = $_POST['fechaInicial'];
    $fechaFinal = $_POST['fechaFinal'];
} else {
    $fechaInicial = null;
    $fechaFinal = null;
}

if ($_SESSION['perfil'] == "SuperAdministrador" || $_SESSION['perfil'] == "Administrador" || $_SESSION['perfil'] == "Caja" || $_SESSION['perfil'] == "Ventas") {

    $respuesta = \ControladorVerventas::ctrListarVentasTerminadas($fechaInicial, $fechaFinal);

    foreach ($respuesta as $key => $value) {

        echo '

        <tr>

            <td>' . ($key + 1) . '</td>
            <td>' . $value["codigo"] . '</td>';

        echo ' <td>' . $value["cliente_nombre"] . '</td>';

        echo '<td>' . $value["vendedor_nombre"] . '</td>
            <td>' . $value["total"] . '</td>
            <td>' . $value["estado"] . '</td>
            <td>' . $value["fecha"] . '</td>';

        echo '<td>

            <div class="btn-group">

            <button class="btn btn-info btnImprimirFacturaFinal" codigoVenta="' . $value["codigo"] . '" idVentas="' . $value["id"] . '">

            <i class="fa fa-file-pdf-o"></i>
            </button>

            </div>

        </td>

    </tr> ';
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

                    window.location = "principal";

                    }
                })

    </script>';
}

?>
