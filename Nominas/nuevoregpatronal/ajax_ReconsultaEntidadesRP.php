<?php
require "../../vista/conexion.php";
require_once ("../../libs/logger/KLogger.php");
date_default_timezone_set('America/Mexico_City');
$log = new KLogger ("ajax_ReconsultaEntidadesRP.log" , KLogger::DEBUG );
$response = array();
$response["status"] = "error";

$entidades = array();
$entidadesSel = $_POST['entidadesSeleccionadas'];

try{
    $sql1 = "SELECT idEntidadFederativa, nombreEntidadFederativa
             FROM entidadesfederativas 
             WHERE idEntidadFederativa!='33'
             AND idEntidadFederativa!='50'
             AND idEntidadFederativa!='$entidadesSel[0]'";

             if (count($entidadesSel)>1) {

              for ($i=0; $i < count($entidadesSel); $i++) { 
                  $sql1.= " AND idEntidadFederativa!='$entidadesSel[$i]'";
              }
             }

    $log->LogInfo("Valor de variable sql1" . var_export ($sql1, true));
    $res1 = mysqli_query($conexion, $sql1);
    while(($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
           $entidades[] = $reg1;
    }
    $log->LogInfo("Valor de variable entidades" . var_export ($entidades, true));
    $response["entidades"] = $entidades;
    $response["status"] = "success";
}catch(Exception $e){
       $response["message"] = "Error al iniciar sesion";
}
echo json_encode($response);