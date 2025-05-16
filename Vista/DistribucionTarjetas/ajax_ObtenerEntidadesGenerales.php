<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$usuario             = $_SESSION ["userLog"]["usuario"];
$datos              = array();
//$log = new KLogger ( "ajax_ObtenerEntidadesGenerales.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _SESSION " . var_export ($_SESSION, true));
try {
        $sql = "SELECT * from entidadesfederativas 
        where idEntidadFederativa != '50'";
      //  $log->LogInfo("Ejecutando matricesEntidades  insert: " . $sql); 
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));

    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al Obtener Matrices";}
echo json_encode($response);
