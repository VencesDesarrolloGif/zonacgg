<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response           = array();
$response["status"] = "error";
$repse              = array();
//$log = new KLogger ( "ajaxconsultaRepse.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de variable repse" . var_export ($repse, true));
try {
    $repse = $negocio->consultaRepse();

    $docrepse = $negocio->obtenerUltimorepse();//se reutiliza la funcion
    $response["nombreDocumento"]= $docrepse[0]["nombreDocumento"];//se reutiliza la funcion
    
    $response["status"] = "success";
    $response["datos"]  = $repse;

 }catch (Exception $e) {
    $response["message"] = "Error al iniciar sesion";
	}
echo json_encode($response);