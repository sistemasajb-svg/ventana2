<?php 

require_once "conexion.php";

class ModeloClientes{

    static public function mdlMostrarClientes($tabla,$item,$valor){
        
       // $stmtvalix=Conexion::conectar()->prepare("update ventas set `actual` =0, `actualvalidar` = '0' ");
    //    $stmtvalix->execute();
        
        
       $stmtvali=Conexion::conectar()->prepare("update ventas set `actual` = (SELECT saldo from clientes where documento = ventas.`id_cliente`), `actualvalidar` = '1' where `actualvalidar` != '1'");
        $stmtvali->execute();
		      
		         
        if($item !=null){
            
         //   $stmt2 = Conexion::conectar()->prepare("UPDATE clientes SET afavor= 0,amortizacion= (SELECT SUM(ingreso) as TOTAL FROM historialcaja WHERE idcliente= $valor) WHERE id=$valor");
           // $stmt2->execute();
            
            
               






            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=$valor");

            $stmt->execute();
           
            return $stmt->fetch();
       
        }else{


          //  $stmt3 = Conexion::conectar()->prepare("UPDATE clientes SET saldo=total - amortizacion");
          //  $stmt3->execute();

            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");
            $stmt->execute();
          
          
          // Obtener todos los resultados
            $resultados = $stmt->fetchAll();

            // Recorrer los resultados y extraer los IDs
            foreach ($resultados as $row) {

                $ddd = ModeloPagos::mdlMostrarVentasxcliente($row['id']);

            }
            
            return $resultados;

        }

        $stmt->close();
        $stmt=null;

        $stmt2->close();
        $stmt2=null;
       
    }





}


?>