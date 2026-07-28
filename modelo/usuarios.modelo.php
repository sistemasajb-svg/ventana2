<?php 

require_once "conexion.php";

class ModeloUsuarios{

    static public function mdlMostrarUsuarios($tabla,$item,$valor){
        
        
        
        // date('Y-m-d');
         $fechahoy =date('Y-m-d');

        $stmtvv = Conexion::conectar()->prepare("UPDATE caja SET fechaconvertida = date_format(fecha, '%Y-%m-%d')");
        $stmtvv->execute();
        $stmtvvv = Conexion::conectar()->prepare("UPDATE caja SET estado = 'desactivo' where fechaconvertida NOT LIKE  '%$fechahoy%'");
        $stmtvvv->execute();

//date_format(fecha, "%d-%m-%Y")
        if($item !=null){

            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:$item");

            $stmt->bindParam(":".$item ,$valor,PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();

        }else{

        $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

        $stmt->execute();

        return $stmt->fetchAll();

        }


      $stmt->close();
        $stmt=null;


    }




    static public function mdlEditarUsuario($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, password = :password, perfil = :perfil, foto = :foto WHERE usuario = :usuario");


        $stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt -> bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);

        if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;




    }





  





    static public function mdlIngresarUsuario($tabla,$datos){


        $stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(nombre,usuario,password,perfil,foto) VALUES (:nombre,:usuario,:password,:perfil,:foto)");

        $stmt->bindParam(":nombre" ,$datos["nombre"],PDO::PARAM_STR);
        $stmt->bindParam(":usuario" ,$datos["usuario"],PDO::PARAM_STR);
        $stmt->bindParam(":password" ,$datos["password"],PDO::PARAM_STR);
        $stmt->bindParam(":perfil" ,$datos["perfil"],PDO::PARAM_STR);
        $stmt->bindParam(":foto" ,$datos["foto"],PDO::PARAM_STR);


        if($stmt->execute()){

            return "ok";

        }else{

            return "error";


        }

         $stmt->close();

        $stmt=null;

    }



    	/*=============================================
	BORRAR USUARIO
	=============================================*/

    static public function mdlBorrarUsuarios($tabla , $datos){

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id=:id");

        $stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

        if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;








    }


     	/*=============================================
	ACTUALIZAR USUARIO
	=============================================*/



    static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2){

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 =:$item1 WHERE $item2=:$item2");

        $stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

        if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;




    }








}


?>