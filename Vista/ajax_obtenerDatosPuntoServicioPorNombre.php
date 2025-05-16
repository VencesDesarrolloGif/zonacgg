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
		//$log = new KLogger ( "ajaxObtenerPuntosPorNombre.log" , KLogger::DEBUG );
		$nombrePunto=getValueFromPost("nombrePunto");
	try{
		$puntoServicio= $negocio -> traerCatalogoPuntosServiciosByName($nombrePunto);
		$response["puntoServicio"]= $puntoServicio;
		//$log->LogInfo("Valor de variable de nombrePunto que viene de form" . var_export ($nombrePunto, true));
		//$log->LogInfo("Valor de la variable \$response punto: " . var_export ($response, true));
	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Punto Servicio";
	}
}
echo json_encode($response);

?>