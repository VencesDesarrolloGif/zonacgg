<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_PuntoServicioXEntidadyCliente.log" , KLogger::DEBUG );
$ClienteElegido = getValueFromPost ("ClienteElegido");
$EntidadElegida = getValueFromPost ("EntidadElegida");
$lineaNegocio = getValueFromPost ("lineaNegocio");
$valorgifTipo=getValueFromPost ("valorgifTipo"); 

   try {
        $PuntosServicio = $negocio->obtenerPuntoXentidadCliente($EntidadElegida,$ClienteElegido,$lineaNegocio,$valorgifTipo);
        $response["datos"] = $PuntosServicio;
        //$log->LogInfo("Valor de entidad" . var_export ($response, true));
       } 
		catch (Exception $e)
			 {
	    	  $response["status"] = "error";
	    	  $response["error"]  = "No se puedo obtener lista de Marcas";
			 }
echo json_encode($response);
