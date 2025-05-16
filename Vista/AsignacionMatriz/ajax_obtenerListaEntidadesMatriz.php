<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response              = array();
$response["status"]    = "error";
$datos                 = array();
$idMatriz   = $_POST["idMatriz"];
//$log = new KLogger ( "ajax_obtenerListaEntidadesMatriz.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));
try {
    $sql = "SELECT * from matricesentidades
            where IdMatrizPrincipal='$idMatriz'
            and EstatusEntidadesMatriz='1'";      
    
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
