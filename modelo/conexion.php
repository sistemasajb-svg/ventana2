<?php



class Conexion{

    static public function conectar(){


      $link = new PDO("mysql:host=host.cpse13.eu;dbname=y224661_nuevabaseavicolajb" , "y224661_useravicolajb" , "@exenk123456@");
        //  $link = new PDO("mysql:host=localhost;dbname=sistemadeventas" , "root" , "");

        $link->exec("set names utf8");

        return $link;

    }







}








?>