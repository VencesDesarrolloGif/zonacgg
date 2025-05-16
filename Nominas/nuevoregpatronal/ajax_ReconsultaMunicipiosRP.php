<?php
require "../../vista/conexion.php";
require_once ("../../libs/logger/KLogger.php");
date_default_timezone_set('America/Mexico_City');
$log = new KLogger ("ajax_ReconsultaMunicipiosRP.log" , KLogger::DEBUG );
$response = array();
$response["status"] = "error";

$municipios = array();
$municipiosSel = $_POST['municipiosSeleccionados'];
$entidadMunicipio = $_POST['entidadMunicipio'];

try{
    $sql1 = "SELECT idMunicipio, idEstado, nombreMunicipio 
             FROM catalogomunicipios
             WHERE idEstado='$entidadMunicipio'
             AND idMunicipio!='$municipiosSel[0]'";

             if (count($municipiosSel)>1) {

              for ($i=0; $i < count($municipiosSel); $i++) { 
                  $sql1.= " AND idMunicipio!='$municipiosSel[$i]'";
              }
             }

       $sql1.= " ORDER BY nombreMunicipio";


    $log->LogInfo("Valor de variable sql1" . var_export ($sql1, true));
    $res1 = mysqli_query($conexion, $sql1);
    while(($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
           $municipios[] = $reg1;
    }
    $log->LogInfo("Valor de variable municipios" . var_export ($municipios, true));
    $response["municipios"] = $municipios;
    $response["status"] = "success";
}catch(Exception $e){
       $response["message"] = "Error al iniciar sesion";
}
echo json_encode($response);