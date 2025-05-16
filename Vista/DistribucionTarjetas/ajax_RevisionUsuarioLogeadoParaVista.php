<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
$log = new KLogger ( "ajax_RevisionUsuarioLogeadoParaVista.log" , KLogger::DEBUG );
$response = array();
$datos    = array();
$datos1    = array();
$response["status"] = "success";
$usuario            = $_SESSION ["userLog"]["usuario"];
$rol            = $_SESSION ["userLog"]["rol"];
$log->LogInfo("Valor de la variable _SESSION: " . var_export ($_SESSION, true));
try {
    $sql = "SELECT * from asignacionMatriz
            where usuarioAsignacion='$usuario'
            and estatusAsigacionMatriz='1'";      
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    $datos1 = $rol;
    $response["status"]= "success";
    $response["datos"] = $datos;
    $response["datos1"] = $datos1;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
    $log->LogInfo("Valor de la variable response: " . var_export ($response, true));
echo json_encode($response);