<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
// $log = new KLogger ( "ajax_IngresarUsuarioConexion.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));

try {
    $usuario = $_POST ["usuario"];
    $ipIngreso = $_POST ["ipIngreso"];

    $sql0 = "INSERT into HistoricoIngresoSuperUsuarioTemp(histUsuarioTempS, histipIngresadaTempS, histFechaInser) values ('$usuario','$ipIngreso',now())"; 
    $res0 = mysqli_query($conexion, $sql0);  
    $sql = "INSERT into IngresoSuperUsuarioTemp(UsuarioTempS, ipIngresadaTempS) values ('$usuario','$ipIngreso')"; 
        $res = mysqli_query($conexion, $sql);  
    if ($res !== true) {
        $response["status"] = "error";
        $response["message"]="Error al registrar eL inicio De Sesion";
        return;
    }else{
        $response["status"]= "success";
        $response["message"]='La Inserción Se Realizó Correctamente';
    }
}catch (Exception $e) {
    $response["message"] = "Error al registrar eL inicio De Sesion";}
echo json_encode($response);
