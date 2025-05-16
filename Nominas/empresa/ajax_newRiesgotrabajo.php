<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
// $log = new KLogger ( "ajax_newRiesgoEmpresa.log" , KLogger::DEBUG );
$mesriesgo        = $_POST['mesriesgo'];
$anioriesgo       = $_POST['anioriesgo'];
$primariesgo      = $_POST['primariesgo'];
$registropatronal = $_POST['registropatronal'];

$response           = array();
$response["status"] = "error";
$datos              = array();

try {

    $sql = "INSERT INTO primariesgotrabajo(idRegistro, IdPrimaRiesgo, anioPrimaR, mesPrimaR, cantPrimaRiesgo)values('$registropatronal',null,'$anioriesgo','$mesriesgo','$primariesgo')";
    // $log->LogInfo("Valor de variable sql" . var_export ($sql, true));
    $res = mysqli_query($conexion, $sql);
    if ($res !== true) {
        $response["mensaje"]= 'error al eliminar documento';
        $response["status"] = "error";
        return;
    }else{
        $response["status"] = "success";
        $response["mensaje"]= 'Se Genero Correctamente';
    }
} catch (Exception $e) {

    $response["message"] = "Error al iniciar sesion";

}

echo json_encode($response);
