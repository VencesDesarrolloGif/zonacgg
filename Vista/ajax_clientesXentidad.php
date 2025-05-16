<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_obtenerClientesXlineaNegocio.log" , KLogger::DEBUG );
$LineaNegocioElegida = getValueFromPost ("LineaNegocioElegida");
$EntidadElegida=getValueFromPost ("EntidadElegida"); 
try{
    $clientes = $negocio->obtenerClienteXEntidad($LineaNegocioElegida,$EntidadElegida);
    $response["datos"] = $clientes;
	//$log->LogInfo("Valor de Clienets" . var_export ($response, true));
   }catch(Exception $e) {
	    $response["status"] = "error";
	    $response["error"]  = "No se puedo obtener lista de Clientes";
	}
echo json_encode($response);
