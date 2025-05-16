<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_borrarRegistrodeIngresoSU.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));

try {
    $IpABorrar = $_POST ["IpABorrar"];
    if($IpABorrar=="0"){
        $sql = "truncate IngresoSuperUsuarioTemp";
    }else{
    $sql = "DELETE from IngresoSuperUsuarioTemp 
            where ipIngresadaTempS='$IpABorrar'";     
    }
    $res = mysqli_query($conexion, $sql);  
    if ($res !== true) {
        $response["status"] = "error";
        $response["message"]='error al ACTUALIZAR el super usuario';
        return;
    }else{
        $response["status"]= "success";
        $response["message"]='El bloqueo Se Realizó Correctamente';
    }
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
