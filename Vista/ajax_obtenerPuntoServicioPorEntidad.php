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

	
		//$log = new KLogger ( "ajaxObtenerPuntosPorEntidad.log" , KLogger::DEBUG );
		$idEntidad=getValueFromPost("idEntidad");
		$estatusPunto=getValueFromPost("estatusPunto");
		$estatusEmpleadoh=getValueFromPost("estatusEmpleadoh");


	try{ 
		

		$puntoServicio= $negocio -> negocio_obtenerPuntosServiciosPorEntidad($idEntidad,$estatusPunto,$estatusEmpleadoh);
		$response["puntoServicio"]= $puntoServicio;

		//$log->LogInfo("Valor de variable de idEntidad que viene de form" . var_export ($idEntidad, true));
		//$log->LogInfo("Valor de variable estatusPunto substr" . var_export ($estatusPunto, true));

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