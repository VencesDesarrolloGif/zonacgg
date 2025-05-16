<?php
session_start();
require "../../vista/conexion.php";
require_once ("../../libs/logger/KLogger.php");
date_default_timezone_set('America/Mexico_City');
$log = new KLogger ("ajax_ConsultarMunicipiosXEntidad.log" , KLogger::DEBUG );
$response = array();
$response["status"] = "error";
$entidad = $_POST['entidadSelect'];

    $log->LogInfo("Valor de variable entidad" . var_export ($entidad, true));
$municipios = array();

try{
    $sql1 = "SELECT DISTINCT nombreMunicipio,idMunicipio
             FROM asentamientos a
             LEFT JOIN catalogomunicipios cm on cm.idMunicipio=a.municipioAsentamiento
             WHERE idEstado=$entidad
             ORDER BY nombreMunicipio";

    $res1 = mysqli_query($conexion, $sql1);
    while(($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
           $municipios[] = $reg1;
    }
    $response["municipios"] = $municipios;
    $response["status"] = "success";
}catch(Exception $e){
       $response["message"] = "Error al iniciar sesion";
}
echo json_encode($response);
