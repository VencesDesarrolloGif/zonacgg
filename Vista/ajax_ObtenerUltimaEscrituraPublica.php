<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_ObtenerUltimaEscrituraPublica.log" , KLogger::DEBUG );
   try{
    	 $escrituraPublica = $negocio->obtenerUltimaEscrituraPublica();
    	 if(count($escrituraPublica)==0) {
    	 	$response["representantelegal"]	   = "";
			$response["administradorunico"]	   = "";
			$response["numerodeescritura"]	   = "";
			$response["nombreDelNotarioPublico"]= "";
			$response["numeroNotarioPublico"]	= "";
			$response["fechaEscrituraPublica"]	= "";
			$response["folioMercantil"]	      = "";
			$response["nombreDocumento"]	      = "";
			$response["caso"]					      = "0";
    	 }else{
    			$response["representantelegal"]	 	= $escrituraPublica[0]["representantelegal"];
    			$response["administradorunico"]	 	= $escrituraPublica[0]["administradorunico"];
    			$response["numerodeescritura"]	   = $escrituraPublica[0]["numerodeescritura"];
    			$response["nombreDelNotarioPublico"]= $escrituraPublica[0]["nombreDelNotarioPublico"];
    			$response["numeroNotarioPublico"]	= $escrituraPublica[0]["numeroNotarioPublico"];
    			$response["fechaEscrituraPublica"]	= $escrituraPublica[0]["fechaEscrituraPublica"];
    			$response["folioMercantil"]	 		= $escrituraPublica[0]["folioMercantil"];
    			$response["nombreDocumento"]	 		= $escrituraPublica[0]["nombreDocumento"];
				$response["caso"]					      = "1";

    	  // $response["fechaCargaEscritura"] 	 = $escrituraPublica[0]["fechaCargaEscritura"];
   	  // $log->LogInfo("Valor de LineasNegocio" . var_export ($response, true));
   	}
   } 
	catch (Exception $e) {
	    $response["status"] = "error";
	    $response["error"]  = "No se puedo obtener lista de Marcas";
	}
echo json_encode($response);
