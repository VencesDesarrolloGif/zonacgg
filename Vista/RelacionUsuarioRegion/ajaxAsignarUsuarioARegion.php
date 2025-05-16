<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$datos              = array();
$response = array("status" => "success");
// $log = new KLogger ( "ajax_AsignarUsuarioARegion.log" , KLogger::DEBUG );

try {
    // $log->LogInfo("Valor de la variable _SESSION " . var_export ($_SESSION, true));
    $region = $_POST['region'];
    $usuario= $_POST['usuario'];
    $lineaNegocio= $_POST['lineaNegocio'];
    $usuarioLog=$_SESSION['userLog']['usuario'];

    $sql = "INSERT INTO relacionUsuarios_regiones(idRegionI,idUsuario, usrLog, fechaCreacion,idLineaNegocioRUR) VALUES($region,$usuario,'$usuarioLog',now(),$lineaNegocio)";     
    $res = mysqli_query($conexion, $sql);
        // $log->LogInfo("Valor de la variable sql " . var_export ($sql, true));

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se puedo obtener lista de datos";
}
echo json_encode($response);
