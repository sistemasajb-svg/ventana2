<?php 

require_once "conexion.php";

class ModeloUsuarios{

    static private function campoSeguro($campo, $permitidos, $default)
    {
        return in_array($campo, $permitidos, true) ? $campo : $default;
    }

    static private function campoOpcional($campo, $permitidos)
    {
        if ($campo === null) {
            return null;
        }

        return in_array($campo, $permitidos, true) ? $campo : null;
    }

    static public function mdlMostrarUsuarios($tabla,$item,$valor){
        $tabla = self::campoSeguro($tabla, array('usuarios'), 'usuarios');
        $item = self::campoOpcional($item, array('id', 'usuario', 'perfil', 'estado'));
        
        
        
        // date('Y-m-d');
         $fechahoy =date('Y-m-d');

        $stmtvv = Conexion::conectar()->prepare("UPDATE caja SET fechaconvertida = date_format(fecha, '%Y-%m-%d')");
        $stmtvv->execute();
        $stmtvvv = Conexion::conectar()->prepare("UPDATE caja SET estado = 'desactivo' where fechaconvertida NOT LIKE :fechahoy");
        $stmtvvv->bindValue(":fechahoy", "%$fechahoy%", PDO::PARAM_STR);
        $stmtvvv->execute();

//date_format(fecha, "%d-%m-%Y")
        if($item !=null){

            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valor");

            $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);

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

        $tabla = self::campoSeguro($tabla, array('usuarios'), 'usuarios');

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

        $tabla = self::campoSeguro($tabla, array('usuarios'), 'usuarios');


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

        $tabla = self::campoSeguro($tabla, array('usuarios'), 'usuarios');

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

        $tabla = self::campoSeguro($tabla, array('usuarios'), 'usuarios');
        $item1 = self::campoSeguro($item1, array('nombre', 'password', 'perfil', 'foto', 'estado'), 'nombre');
        $item2 = self::campoSeguro($item2, array('id', 'usuario', 'perfil'), 'id');

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :valor1 WHERE $item2 = :valor2");

        $stmt -> bindParam(":valor1", $valor1, PDO::PARAM_STR);
        $stmt -> bindParam(":valor2", $valor2, PDO::PARAM_STR);

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
