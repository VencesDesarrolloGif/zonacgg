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
	//$log = new KLogger ( "ajax_CargarSelectoresDatosFiscales.log" , KLogger::DEBUG );
	$Caso=getValueFromPost("Caso");
	try{ 
		$datos= $negocio -> negocio_CargarSelectoresDatosFiscales($Caso);
		$response["datos"]= $datos;
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