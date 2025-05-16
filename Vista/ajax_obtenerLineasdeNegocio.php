<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";

$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_obtenerLineaNeg.log" , KLogger::DEBUG );

   try {

    $LineasNegocio = $negocio->obtenerLineasDeNegocio();
    $response["valor"] = $LineasNegocio;
    
   // $log->LogInfo("Valor de LineasNegocio" . var_export ($response, true));
   } 
	catch (Exception $e) {
	    $response["status"] = "error";
	    $response["error"]  = "No se puedo obtener lista de Marcas";
	}
echo json_encode($response);
