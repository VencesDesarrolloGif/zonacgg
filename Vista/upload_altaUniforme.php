<?php
session_start ();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion($negocio);
//$log = new KLogger ( "ajax_uploadAlta.log" , KLogger::DEBUG );
// Obtenemos los datos del empleado
$numeroEmpleadoEntidad = $_POST["empEnt"];
$numeroEmpleadoConsecutivo = $_POST["empCon"];
$numeroEmpleadoTipo = $_POST ["empCat"];
$tipo = $_POST ["formato"];

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
    //$log->LogInfo("Valor de la variable \$tipo: " . var_export ($tipo, true));
  if($tipo=='1'){
     $keyOfFileUpload = "docoumentoAlta";
     $target_dir = dirname (__FILE__) . 
         DIRECTORY_SEPARATOR . "uploads" . 
         DIRECTORY_SEPARATOR . "fAltas" . 
         DIRECTORY_SEPARATOR;
         
     $target_file = $target_dir . $numeroEmpleadoEntidad.$numeroEmpleadoConsecutivo.$numeroEmpleadoTipo;
    
     //obtenemos el archivo a subir
     $file = $_FILES['docoumentoAlta'];
     //comprobamos si existe un directorio para subir el archivo
     //si no es así, lo creamos
     if (!is_uploaded_file($_FILES[$keyOfFileUpload]['tmp_name'])){
         echo "<script>alert('Error en archivo');location.href ='/zonacgg/Vista/usuarioLogeado.php';</script>";
         exit;
     }
     if (!move_uploaded_file($_FILES[$keyOfFileUpload]["tmp_name"], $target_file.".pdf")){   
         sleep(3);//retrasamos la petición 3 segundos
         echo "<script>alert('Error en el servidor');location.href ='/zonacgg/Vista/usuarioLogeado.php';</script>";
           //$log->LogInfo("hola no se movio");//devolvemos el nombre del archivo para pintar la imagen
     }
         //$direccion="/uploads/prueba/";
         //$direccion.=$numeroEmpleadoEntidad.$numeroEmpleadoConsecutivo.$numeroEmpleadoTipo.".jpeg";
  }else{
       $keyOfFileUpload = "docoumentoBaja";
       $target_dir = dirname (__FILE__) . 
          DIRECTORY_SEPARATOR . "uploads" . 
          DIRECTORY_SEPARATOR . "fBajas" . 
          DIRECTORY_SEPARATOR;
      $target_file = $target_dir . $numeroEmpleadoEntidad.$numeroEmpleadoConsecutivo.$numeroEmpleadoTipo;

      //obtenemos el archivo a subir
      $file = $_FILES['docoumentoBaja'];

       if (!is_uploaded_file($_FILES[$keyOfFileUpload]['tmp_name'])){
          echo "<script>alert('Error en archivo');location.href ='/zonacgg/Vista/usuarioLogeado.php';</script>";
          exit;
      }
      //$log->LogInfo("Valor de la variable \$file: " . var_export ($file, true));
      if (!move_uploaded_file($_FILES[$keyOfFileUpload]["tmp_name"], $target_file.".pdf")){   
          sleep(3);//retrasamos la petición 3 segundos
          echo "<script>alert('Error en el servidor');location.href ='/zonacgg/Vista/usuarioLogeado.php';</script>";
          //$log->LogInfo("hola no se movio");//devolvemos el nombre del archivo para pintar la imagen
      }
  }
    //comprobamos si el archivo ha subido
}else{
    throw new Exception("Error Processing Request", 1);   
}

?> 