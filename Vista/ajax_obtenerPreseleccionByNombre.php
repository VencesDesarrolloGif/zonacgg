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

	
		// $log = new KLogger ( "ajax_obtenerPreseleccionByNombre.log" , KLogger::DEBUG );
		$nombre=getValueFromPost("nombre");
		


	try{
		
		$preseleccion= $negocio -> negocio_obtenerPreseleccionPorNombre($nombre);
		$response["aspirante"]= $preseleccion;

		// $log->LogInfo("Valor de variable de nombre que viene de form" . var_export ($nombre, true));
		// $log->LogInfo("Valor de la variable \$preseleccion : " . var_export ($preseleccion, true));

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se pudo obtener el aspirante";
	}
}

echo json_encode($response);

?>