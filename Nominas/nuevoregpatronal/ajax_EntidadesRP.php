<?php
session_start();
require "../../vista/conexion.php";
require_once ("../../libs/logger/KLogger.php");
date_default_timezone_set('America/Mexico_City');
// $log = new KLogger ("ajax_EntidadesRP.log" , KLogger::DEBUG );
$response = array();
$response["status"] = "error";

$entidades = array();

try{
    $sql1 = "SELECT idEntidadFederativa, nombreEntidadFederativa
             FROM entidadesfederativas 
             WHERE idEntidadFederativa!='33'
             AND idEntidadFederativa!='50'";

    $res1 = mysqli_query($conexion, $sql1);
    while(($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
           $entidades[] = $reg1;
    }
    // $log->LogInfo("Valor de variable entidades" . var_export ($entidades, true));
    $response["entidades"] = $entidades;
    $response["status"] = "success";
}catch(Exception $e){
       $response["message"] = "Error al iniciar sesion";
}
echo json_encode($response);