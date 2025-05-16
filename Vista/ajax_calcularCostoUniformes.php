<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";

$negocio = new Negocio();

verificarInicioSesion($negocio);

$response = array("status" => "success");

$puntoServicio = $_POST["puntoServicio"];

$fechaConsulta2    = $_POST["fecha2"];

$fechaConsulta1    = $_POST["fecha1"];

$puestoServ    = $_POST["puesto"];

$roloperativo    = $_POST["roloperativo"];





//$log              = new KLogger("ajaxCalculoEma.log", KLogger::DEBUG);

//$log->LogInfo("Valor de variable fechaPeriodo2: " . var_export ($fechaPeriodo2, true));
try {

        $costo = $negocio->negocio_obtenerCostoUniformes($puestoServ,$puntoServicio, $fechaConsulta1, $fechaConsulta2,$roloperativo);    
        

        
        //$log->LogInfo("Valor de variable empleado: " . var_export ($empleadoId, true));
        //$log->LogInfo("Valor de variable G.M.P.Pat= ".var_export ($ab, true)." G.M.P.Obr= ".var_export ($cd, true));


        $response["totalUniformes"] = $costo;

    //$log->LogInfo("Valor de variable de estatusEmpleado que viene de form" . var_export ($estatusEmpleado, true));

    //$log->LogInfo("Valor de la variable \$response punto: " . var_export ($response, true));

} catch (Exception $e) {
    $response["status"]  = "error";
    $response["message"] = "Error: " . $e->getMessage();
}

echo json_encode($response);
