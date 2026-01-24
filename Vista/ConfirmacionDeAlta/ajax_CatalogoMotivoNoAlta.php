<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$response = array();
$datos    = array();
$response = array("status" => "success");
//$log = new KLogger ( "ajax_ObtenerentidadesIncidenciaCC.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
try {
    $sql = "SELECT * from CatalogoMotivosNoALtaImss";
        //$log->LogInfo("Ejecutando matricesEntidades  aaaa: " . $sql);           
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    $response["datos"]= $datos;
    //$log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));
}catch (Exception $e) {    
    $response["status"]="error";
    $response["error"]="No se puedo obtener los motivos de no alta";
}
echo json_encode($response);
?>