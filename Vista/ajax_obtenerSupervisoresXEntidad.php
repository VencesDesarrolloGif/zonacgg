<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_obtenerSupervisoresXEntidad.log" , KLogger::DEBUG );
$LineaNegocioElegida = getValueFromPost ("LineaNegocioElegida");
$valorgifTipo=getValueFromPost ("valorgifTipo"); 
$entidadElegida=getValueFromPost ("entidadElegida"); 

   try {
    $supervisores = $negocio->obtenerSupervisoresXLinea($LineaNegocioElegida,$valorgifTipo,0,$entidadElegida);
    $response["datos"] = $supervisores;
    //$log->LogInfo("Valor de supervisores" . var_export ($response, true));
   } 
	catch (Exception $e) {
	    $response["status"] = "error";
	    $response["error"]  = "No se puedo obtener lista de Marcas";
	}
echo json_encode($response);
