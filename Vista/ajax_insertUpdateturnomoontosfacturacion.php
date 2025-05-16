<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";

$negocio = new Negocio();

$response = array();

verificarInicioSesion($negocio);
$fecha1        = $_POST["fecha1"];
$fecha2        = $_POST["fecha2"];
$monto         = $_POST["monto"];
$turnosfactu   = $_POST["turnosfactu"];
$llave = $_POST["llave"];

if (!empty($_POST)) {
    // $log = new KLogger("AJAX_INSERT.log", KLogger::DEBUG);

    // $usuario = $_SESSION ["userLog"]["usuario"];

    // $log->LogInfo("Valor de la variable  " . var_export($fecha2, true));

    try
    {
        $negocio->inserupdatemontosfacturacion($fecha1, $fecha2, $monto, $turnosfactu, $llave);
        $response["status"]  = "success";
        $response["message"] = "Edicion finalizada";
    } catch (Exception $e) {
        $response["status"]  = "error";
        $response["message"] = $e->getMessage();
    }
} else {
    $response["status"]  = "error";
    $response["message"] = "No se proporcionaron datos";
}

echo json_encode($response);
