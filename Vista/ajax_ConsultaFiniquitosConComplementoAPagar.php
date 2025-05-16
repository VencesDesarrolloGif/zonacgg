<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio            = new Negocio ();
$response           = array();
$response["status"] = "error";
$datos              = array();
//$usuario = $_SESSION ["userLog"]["usuario"];
try {
    $datos = $negocio -> obtenerListaFiniquitosCompPorPagar();
    for ($i = 0; $i < count($datos); $i++) {       
        $numempleado          = $datos[$i]["numempleado"];
        $folioBajaImss        = $datos[$i]["folioBajaImss"];
        $CantidadComplemento        = $datos[$i]["CantidadComplemento"];
        $datos[$i]["Accion"] = "<img style='width: 15%' title='Al confirmar el registro desaparecerá indicando que ya fue pagado el complemento!!' src='img/confirmarImss.png' class='cursorImg' onclick=ConfirmarComplementoPagodo('$numempleado','$folioBajaImss','$CantidadComplemento')>";
    }
    $response["status"] = "success";
    $response["datos"]  = $datos;
} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
