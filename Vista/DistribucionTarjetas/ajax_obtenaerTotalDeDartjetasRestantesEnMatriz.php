<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
//$log = new KLogger ( "ajax_obtenaerTotalDeDartjetasRestantesEnMatriz.log" , KLogger::DEBUG );
$response = array();
$datos    = array();
$response["status"] = "success";
$usuario            = $_SESSION ["userLog"]["usuario"];
$idMatriz            = $_POST["idMatriz"];
try {
    $sql = "SELECT count(IdTarjetaDespensa) as totalTarjetaDisp from TarjetaDespensa
            where idMatrizAsiganda='$idMatriz'
            and (idEstatusAsignacionEntidad is null or idEstatusAsignacionEntidad = '0')";      
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
    //$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
echo json_encode($response);