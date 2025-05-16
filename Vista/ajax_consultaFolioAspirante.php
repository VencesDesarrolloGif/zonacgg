<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

//verificarInicioSesion ($negocio);

$response = array("status" => "success");


if(!empty ($_POST))
{
		//$log = new KLogger ( "ajaxConsultaEmpleado.log" , KLogger::DEBUG );
		$folioPreseleccion=getValueFromPost("folioAspirante");


	try{

		$aspirante= $negocio -> negocio_obtenerAspirante($folioPreseleccion);
		$response["aspirante"]= $aspirante;
		
		//$log->LogInfo("Valor de la variable \$response empleado: " . var_export ($response, true));

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se obtuvieron datos";
	}
}

echo json_encode($response);

?>