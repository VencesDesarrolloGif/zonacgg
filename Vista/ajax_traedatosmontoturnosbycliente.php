<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";

$negocio = new Negocio();

$response = array();

verificarInicioSesion($negocio);
$llave = $_POST["llave"];
$fecha1        = $_POST["fecha1"];
$fecha2        = $_POST["fecha2"];

if (!empty($_POST)) {
    //$log = new KLogger("AJAX_jegdfsgf.log", KLogger::DEBUG);

    // $usuario = $_SESSION ["userLog"]["usuario"];

    //$log->LogInfo("Valor de la variable  " . var_export($fecha2, true));

    try
    {
        $lista              = $negocio->traedatosmontoturnos($llave, $fecha1, $fecha2);
        $response["status"] = "success";

        if (count($lista) == 0) {
            $lista["TurnosFacturados"] = 0;
            $lista["montoFacturado"]   = 0;
        } else {
            $lista["TurnosFacturados"] = $lista[0]["TurnosFacturados"];
            $lista["montoFacturado"]   = $lista[0]["montoFacturado"];
        }
        //$log->LogInfo("Valor de la lista  " . var_export($lista, true));

        // $response["message"] = "Edicion finalizada";

        $response["valores"] = $lista;
    } catch (Exception $e) {
        $response["status"]  = "error";
        $response["message"] = $e->getMessage();
    }
} else {
    $response["status"]  = "error";
    $response["message"] = "No se proporcionaron datos";
}
echo json_encode($response);
