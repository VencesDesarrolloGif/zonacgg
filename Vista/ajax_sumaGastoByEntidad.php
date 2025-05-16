<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";

$negocio = new Negocio();

verificarInicioSesion($negocio);

$response = array("status" => "success");


$fechaConsulta2    = $_POST["fecha2"];

$fechaConsulta1    = $_POST["fecha1"];

$entidad    = $_POST["entidad"];


// $log              = new KLogger("ajaxSumaGasto.log", KLogger::DEBUG);

//$log->LogInfo("Valor de variable fechaPeriodo2: " . var_export ($fechaPeriodo2, true));
try {

        $promedio = $negocio->negocio_promedioGasto($entidad, $fechaConsulta1, $fechaConsulta2);    
        

        
        //$log->LogInfo("Valor de variable entidad: " . var_export ($entidad, true));
        //$log->LogInfo(" Valor de variable gasto= ".var_export ($promedio, true));


        $response["totalPromedio"] = $promedio;

    //$log->LogInfo("Valor de variable de estatusEmpleado que viene de form" . var_export ($estatusEmpleado, true));

    //$log->LogInfo("Valor de la variable \$response punto: " . var_export ($response, true));

} catch (Exception $e) {
    $response["status"]  = "error";
    $response["message"] = "Error: " . $e->getMessage();
}

echo json_encode($response);
