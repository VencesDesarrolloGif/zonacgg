<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

	    // $log = new KLogger ( "ajax_getCoberturaPerfil.log" , KLogger::DEBUG );
		$fecha1=getValueFromPost("fecha1");
		$fecha2=getValueFromPost("fecha2");
		$servicioPlantillaId=getValueFromPost("servicioPlantillaId");
		$puntoServicioAsistenciaId=getValueFromPost("puntoServicioAsistenciaId");

	try{


		$response["turnosCubiertos"]= $negocio -> getTurnosCubiertosByPlantilla($fecha1, $fecha2, $servicioPlantillaId, $puntoServicioAsistenciaId);


		// $log->LogInfo("Valor de la variable \$response punto: " . var_export ($response, true));

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se pudo obtener Empleados";
	}
/*
}
*/

echo json_encode($response);

?>