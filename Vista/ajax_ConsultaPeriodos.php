<?php
session_start();
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$response = array("status" => "success");
require "conexion.php";
$log = new KLogger ( "ajax_obtenerPeriodos.log" , KLogger::DEBUG );
$log->LogInfo("Valor de la variable _POST : " . var_export ($_POST, true));

$idPeriodoActual = array();
$datos = array();
$idPuntoServicio=$_POST['idPuntoServicio'];

try{

    $sql1 = "SELECT idPeriodo
             FROM zonagif.catalogopuntosservicios
             WHERE idPuntoServicio='$idPuntoServicio'";

    $res1 = mysqli_query($conexion, $sql1);
    while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
        $idPeriodoActual[] = $reg1;
    }
$log->LogInfo("Valor de la variable idPeriodoActual : " . var_export ($idPeriodoActual, true));

    $sql = "SELECT IdPeriodo, Descripcion
             FROM periodos";

    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    $response["datos"]= $datos;
    $response["idPeriodoActual"]= $idPeriodoActual;

    $log->LogInfo("Valor de la variable response : " . var_export ($response, true));
}catch( Exception $e ){
    $response["status"]="error";
    $response["error"]="No se puedo obtener la cantidad de empleados en esta plantilla";
}
echo json_encode($response);
 ?>