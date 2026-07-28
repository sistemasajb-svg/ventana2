<?php

require_once "../controladores/personas.controlador.php";
require_once "../modelo/personas.modelo.php";


class AjaxPersonas{

    	/*=============================================
	EDITAR CLIENTE
	=============================================*/	

    public $idPersona;

    public function ajaxEditarPersona(){

        $item="id";
        $valor=$this->idPersona;

         

        $respuesta=ControladorPersonas::ctrMostrarPersonas($item,$valor);

        

        echo json_encode($respuesta);





    }




}

  	/*=============================================
	EDITAR CLIENTE
	=============================================*/	

    if(isset($_POST["idPersona"])){

        $persona=new AjaxPersonas();
        $persona->idPersona= $_POST["idPersona"];
        $persona->ajaxEditarPersona();

    }







?>