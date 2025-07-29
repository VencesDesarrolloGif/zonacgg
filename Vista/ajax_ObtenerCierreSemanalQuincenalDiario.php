<?php
session_start();
date_default_timezone_set('America/Mexico_City');
require "conexion.php"; 
require_once("../libs/logger/KLogger.php");
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$log = new KLogger("ajax_ObtenerCierreSemanalQuincenalDiario.log", KLogger::DEBUG);
$response = array();
$response["status"] = "success";
$response["mensaje"] = "";
// $hora_actual = date("H:i:s");
$fechaFormateada = date("Y-m-d");
try {
    // consultar el numero del gerente regional por el usuario que se loguea 
    $QueryQuincenal = "SELECT * FROM cierreautomatico_nominaquincenal WHERE fecha_cierre >= CAST('$fechaFormateada' AS DATE) and estatus = '0' limit 1";
    $res1 = mysqli_query($conexion, $QueryQuincenal);
    $DatosQuincenales = [];
    while ($reg1 = mysqli_fetch_assoc($res1)) {
        $DatosQuincenales[] = $reg1;
    }
    $FechaQuincenal = $DatosQuincenales[0]["fecha_cierre"];
    $HoraQuincenal = $DatosQuincenales[0]["hora_cierre"];

    $QuerySemanal = "SELECT * from cierreautomatico_nominasemanal WHERE fecha_cierreSemanal >= CAST('$fechaFormateada' AS DATE) and estatus_cierreSemanal = '0' limit 1";
    $res2 = mysqli_query($conexion, $QuerySemanal);
    $DatosSemanal = [];
    while ($reg2 = mysqli_fetch_assoc($res2)) {
        $DatosSemanal[] = $reg2;
    }
    $FechaSemanal = $DatosSemanal[0]["fecha_cierreSemanal"];
    $HoraSemanal = $DatosSemanal[0]["hora_cierreSemanal"];

    $response["FechaQuincenal"] = $FechaQuincenal;
    $response["HoraQuincenal"] = $HoraQuincenal;
    $response["FechaSemanal"] = $FechaSemanal;
    $response["HoraSemanal"] = $HoraSemanal;
    $response["mensaje"] = "correcto";
    
    $log->LogInfo("response: " . var_export($response, true));
} catch (Exception $e) {
    $response["status"] = "error";
    $response["mensaje"] = $e->getMessage();
    $log->LogError("Error en la ejecución: " . $e->getMessage());
}
echo json_encode($response);
