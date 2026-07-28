<?php

require_once "../controladores/pendientes.controlador.php";
require_once "../modelo/pendientes.modelo.php";


class AjaxPendientes{

    	/*=============================================
	EDITAR CLIENTE
	=============================================*/	

    public $idPendiente;

    public function ajaxEditarPendiente(){

        $item="id";
        $valor=$this->idPendiente;

         

        $respuesta=ControladorPendientes::ctrMostrarPendientes($item,$valor);

        

        echo json_encode($respuesta);





    }




}

  	/*=============================================
	EDITAR CLIENTE
	=============================================*/	

    if(isset($_POST["idPendiente"])){

        $pendiente=new AjaxPendientes();
        $pendiente->idPendiente= $_POST["idPendiente"];
        $pendiente->ajaxEditarPendiente();

    }







?>