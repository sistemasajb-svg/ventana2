<?php

require_once __DIR__ . "/config.php";



class Conexion{

    static public function conectar(){


      $link = new PDO(
          "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
          DB_USER,
          DB_PASS,
          array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
      );

        $link->exec("set names utf8mb4");

        return $link;

    }







}








?>
