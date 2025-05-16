<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajaxObtenerEmpleadoPorId.log" , KLogger::DEBUG );
if(!empty ($_POST))
{
	$palabraAntisonante = $_POST["palabraAntisonante"];
	try{

		$CatalogoPalabraAntison= $negocio -> negocio_obtenerPalabraAntisonante($palabraAntisonante);
		$response["CatalogoPalabraAntison"]= $CatalogoPalabraAntison;
	//$log->LogInfo("Valor de variable de empleadoId que viene de form" . var_export ($response, true));
	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Empleado";
	}
}

echo json_encode($response);

?>