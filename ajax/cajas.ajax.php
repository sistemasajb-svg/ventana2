<?php 

require_once "../controladores/cajas.controlador.php";
require_once "../modelo/cajas.modelo.php";



class AjaxCajas{


    public $idCaja;


    public function ajaxEditarCajas(){

        $item="id";
        $valor=$this->idCaja;
        $respuesta=ControladorCajas::ctrMostrarCajas($item,$valor);

        echo json_encode($respuesta);

    }


    	/*=============================================
	ACTIVAR USUARIO
	=============================================*/	

	public $activarCaja;
	public $activarId;


    public function ajaxActivarCajas(){

        $tabla="caja";

        $item1="estado";
        $valor1=$this->activarCaja;

        $item2 = "id";
		$valor2 = $this->activarId;

        $respuesta = ModeloCajas::mdlActualizarCajascierre($tabla, $item1, $valor1, $item2, $valor2);

    }

}




/*=============================================
EDITAR CAJA
=============================================*/

if(isset($_POST["idCaja"])){

$editar=new AjaxCajas();
$editar->idCaja=$_POST["idCaja"];
$editar->ajaxEditarCajas();



}



/*=============================================
ACTIVAR CAJA
=============================================*/	

if(isset($_POST["activarCaja"])){

	$activarCaja = new AjaxCajas();
	$activarCaja -> activarCaja = $_POST["activarCaja"];
	$activarCaja -> activarId = $_POST["activarId"];
	$activarCaja -> ajaxActivarCajas();

}








?>