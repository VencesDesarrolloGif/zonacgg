<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
$EjercicioT           = $_POST["EjercicioT"];
//$log = new KLogger ( "ajax_obtenerFehcaInicioCansultaTarj.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
try {
    $sql = "SELECT * FROM rangoperiodos
            where IdAnio = '$EjercicioT'";    
            //$log->LogInfo("Ejecutando rangoperiodos: " . $sql);  
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));

    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al Obtener Años Del Periodo";}
echo json_encode($response);
