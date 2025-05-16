<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_ObtenerUltimoREPSE.log" , KLogger::DEBUG );
   try{
    	 $repse = $negocio->obtenerUltimorepse();
       $response["nombreDocumento"]= $repse[0]["nombreDocumento"];
		 $response["caso"]= "1";
    	  // $response["fechaCargaEscritura"] 	 = $repse[0]["fechaCargaEscritura"];
   	  // $log->LogInfo("Valor de LineasNegocio" . var_export ($response, true));
   } 
	catch (Exception $e) {
	    $response["status"] = "error";
	    $response["error"]  = "No se pudo obtener Documento Repse";
	}
echo json_encode($response);
