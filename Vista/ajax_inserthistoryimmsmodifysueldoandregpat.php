<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";

$negocio = new Negocio();

$response = array();

verificarInicioSesion($negocio); 
$entidademp        = $_POST["entidademp"];
$consecutivoemp    = $_POST["consecutivoemp"];
$categoriaemp      = $_POST["categoriaemp"];
$tipomovimiento    = $_POST["tipomovimiento"];
$salarioDiario     = $_POST["salarioDiario"];
$registroPatronal  = $_POST["registroPatronal"];
$fechaingreso      = $_POST["fechaingreso"];
$fechabaja         = $_POST["fechabaja"];
$diastranscurridos = $_POST["diastranscurridos"];

/////calculo
$aguinaldo = 15 / 365;
$unidad    = 1;

if ($diastranscurridos <= 365) {
    $primaVacacional = 3;

} elseif ($diastranscurridos >= 366 and $diastranscurridos <= 730) {

    $primaVacacional = 3.5;

} elseif ($diastranscurridos >= 731 and $diastranscurridos <= 1095) {

    $primaVacacional = 4;
} elseif ($diastranscurridos >= 1096 and $diastranscurridos <= 1460) {

    $primaVacacional = 4.5;

} elseif ($diastranscurridos >= 1461 and $diastranscurridos <= 1825) {

    $primaVacacional = 5;

} elseif ($diastranscurridos >= 1826 and $diastranscurridos <= 3650) {

    $primaVacacional = 5.5;

} elseif ($diastranscurridos >= 3651 and $diastranscurridos <= 5475) {

    $primaVacacional = 6;

} elseif ($diastranscurridos >= 5476 and $diastranscurridos <= 7300) {

    $primaVacacional = 6.5;

} elseif ($diastranscurridos >= 7301 and $diastranscurridos <= 9125) {

    $primaVacacional = 7;

} elseif ($diastranscurridos >= 9126 and $diastranscurridos <= 10950) {

    $primaVacacional = 7.5;

} elseif ($diastranscurridos >= 10951 and $diastranscurridos <= 12775) {

    $primaVacacional = 8; 

}


$factorintegracion     = $unidad + ($primaVacacional / 365) + $aguinaldo;
$salariobasecotizacion = $factorintegracion * $salarioDiario;

////////

if (!empty($_POST)) {
    // $log = new KLogger("ajax_historicomovimss.log", KLogger::DEBUG);

    $usuario = $_SESSION["userLog"]["usuario"];

    // $log->LogInfo("Valor de la variable \$datosImss: " . var_export($folioimss, true)); 
    try
    {

        $negocio->inserthistoricomovporeditsueldooregpatronal($entidademp, $consecutivoemp, $categoriaemp, $tipomovimiento, $salarioDiario, $registroPatronal, $usuario, $fechaingreso, $fechabaja, $factorintegracion, $salariobasecotizacion);

        $response["status"]  = "success";
        $response["message"] = "Registro con éxito";

    } catch (Exception $e) {
        $response["status"]  = "error";
        $response["message"] = $e->getMessage();
    }
} else {
    $response["status"]  = "error";
    $response["message"] = "No se proporcionaron datos";
}

echo json_encode($response);
