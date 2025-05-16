<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
//$log = new KLogger ( "ajax_RevisionUsuarioLogeadoParaVista.log" , KLogger::DEBUG );
$response = array();
$datos    = array();
$response["status"] = "success";
$usuario            = $_SESSION ["userLog"]["usuario"];
try {
    $sql = "SELECT * from asignacionMatriz
            where usuarioAsignacion='$usuario'
            and estatusAsigacionMatriz='1'";      
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
  //  $log->LogInfo("Valor de la variable response: " . var_export ($response, true));
echo json_encode($response);