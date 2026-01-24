<?php
session_start();
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$response = array("status" => "success");
require "conexion.php";
// $log = new KLogger ( "ajax_obtenerPeriodosParaPS.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _POST : " . var_export ($_POST, true));
$datos = array();

try{

    $sql = "SELECT IdPeriodo, Descripcion
             FROM periodos";

    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    $response["datos"]= $datos;

    // $log->LogInfo("Valor de la variable response : " . var_export ($response, true));
}catch( Exception $e ){
    $response["status"]="error";
    $response["error"]="No se puedo obtener la cantidad de empleados en esta plantilla";
}
echo json_encode($response);
 ?>