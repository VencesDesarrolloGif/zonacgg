<?php
session_start();

require_once "../Negocio/Negocio.class.php"; 
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_GetCierrePeridoParaBtnBorrar.log" , KLogger::DEBUG );

$fechaActual = date("Y-m-d");  
$fechaActualHora = date("Y-m-d h:i:s");
try {
    $datos   = $negocio->GetCierrePeridoParaBtnBorrar();
    $fehcaREgistro = $datos[0]["fechaCierrePeriodo"]; 
    $explodeFechaRegistro = explode(" ", $fehcaREgistro);
    $FechaAComparar = $explodeFechaRegistro[0];
    //$FechaAComparar = "2021-11-29";
    $fehcaCambioP = $datos[0]["fechaCambioPeriodo"]; 
    //$fehcaCambioP = "2021-12-01";
    //$log->LogInfo("Valor de FechaAComparar" . var_export ($FechaAComparar, true));
    if(($fechaActual >= $FechaAComparar) && ($fechaActualHora <= $fehcaCambioP)  && (!($fechaActual<$FechaAComparar))){
        $CondicionBoton = "0";
    }else{
        $CondicionBoton = "1";
    }
    $response["datos"][0]["CondicionBoton"]=$CondicionBoton;
} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Obtuvo El Estatus Del Empleado";
}
//$log->LogInfo("Valor de response" . var_export ($response, true));
echo json_encode($response);