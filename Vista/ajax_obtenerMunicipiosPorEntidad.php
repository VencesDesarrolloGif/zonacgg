<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");


if(!empty ($_POST))
{

	
		//$log = new KLogger ( "ajaxConsultaMunicipiosPorEntidad.log" , KLogger::DEBUG );
		$idEntidad=getValueFromPost ("entidadId");

	try{
		
	

		$listaMunicipios = $negocio -> negocio_traerListaMunicipiosPorEntidad($idEntidad);
		$response["listaMunicipios"]= $listaMunicipios;
		$Entidades = $negocio -> negocio_obtenerclaveEntidadCurp($idEntidad);
		$response["EntidadCurp"]= $Entidades;

		//$log->LogInfo("Valor de entidad" . var_export ($idEntidad, true));
		//$log->LogInfo("Valor de response" . var_export ($response, true));
		

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo listaMunicipios";
	}
}

echo json_encode($response);

?>