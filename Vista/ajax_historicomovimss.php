<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
 
$negocio = new Negocio();

$response = array();

verificarInicioSesion($negocio);
$folioimss  = $_POST["folioTxt"];
$accion     = $_POST["accion"];
$numeroLote = $_POST["numeroLote"];

if (!empty($_POST)) {
    // $log = new KLogger("ajax_historicomovimss.log", KLogger::DEBUG); 

    $usuario = $_SESSION["userLog"]["usuario"];

    //$log->LogInfo("Valor de la variable \$datosImss: " . var_export($folioimss, true));
    try
    {

        $negocio->obtenerempleadosimssphistoricomov($folioimss, $usuario, $accion, $numeroLote);

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
