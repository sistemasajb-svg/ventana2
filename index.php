<?php 

// Establecer la zona horaria a Perú
date_default_timezone_set('America/Lima');


require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/cajas.controlador.php";
require_once "controladores/pagos.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/verventas.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/personas.controlador.php";
require_once "controladores/ingresoegresos.controlador.php";
require_once "controladores/pendientes.controlador.php";
require_once "controladores/pagomasivo.controlador.php";

require_once "modelo/pagomasivo.modelo.php";
require_once "modelo/usuarios.modelo.php";
require_once "modelo/cajas.modelo.php";
require_once "modelo/pagos.modelo.php";
require_once "modelo/verventas.modelo.php";
require_once "modelo/clientes.modelo.php";
require_once "modelo/productos.modelo.php";
require_once "modelo/personas.modelo.php";
require_once "modelo/ingresoegresos.modelo.php";
require_once "modelo/pendientes.modelo.php";



$plantilla =new ControladorPlantilla();
$plantilla->ctrPlantilla();



?>