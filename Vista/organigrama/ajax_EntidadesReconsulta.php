<?php
session_start();
require "../conexion.php";
require_once ("../../libs/logger/KLogger.php");
date_default_timezone_set('America/Mexico_City');
// $log = new KLogger ("ajax_EntidadesReconsulta.log" , KLogger::DEBUG );
$response = array();

$entidadesNuevas = array();
$arrayEntidades=$_POST['entidadesCompletasSelect'];
       $sqlEntNuevas = " SELECT idEntidadFederativa, nombreEntidadFederativa
                 FROM entidadesfederativas 
                 WHERE idEntidadFederativa='$arrayEntidades[0]'";

   for ($i=0; $i < count($arrayEntidades); $i++) { 
          // code...
       $sqlEntNuevas.= " OR idEntidadFederativa='$arrayEntidades[$i]'";
   }

          $resEntNuevas = mysqli_query($conexion, $sqlEntNuevas);
          while(($regEntNuevas = mysqli_fetch_array($resEntNuevas, MYSQLI_ASSOC))){
                 $entidadesNuevas[] = $regEntNuevas;
          }
        
    $response["entidades"] = $entidadesNuevas;
    $response["status"] = "success";
// $log->LogInfo("Valor de variable response" . var_export ($response, true));
echo json_encode($response);