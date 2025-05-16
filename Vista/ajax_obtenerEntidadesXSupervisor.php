<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_obtenerEntidadSupervisor.log" , KLogger::DEBUG );
$supervisorElegido = getValueFromPost ("supervisorElegido");
$LineaElegida = getValueFromPost ("LineaElegida");
$valorgifTipo=getValueFromPost ("valorgifTipo"); 

   try {
        $entidades = $negocio->obtenerEntidadSupervisor($supervisorElegido,$LineaElegida,$valorgifTipo);
        $response["datos"] = $entidades;
       } 
	    catch (Exception $e) 
	          {
	           $response["status"] = "error";
	           $response["error"]  = "No se puedo obtener lista de Marcas";
			  }
echo json_encode($response);
