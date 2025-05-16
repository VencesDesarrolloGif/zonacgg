<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
  
$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");
$usuario=$_SESSION["userLog"];


/*
if(!empty ($_POST))
{
*/
	
		//$log = new KLogger ( "ajaxObtenerDetalleAsistencia.log" , KLogger::DEBUG );

		$fecha1=getValueFromPost("fechaConsulta1");
		$fecha2=getValueFromPost("fechaConsulta2");

	try{
		

		$lista= $negocio -> getDetalleIncidenciasEspeciales($fecha1, $fecha2,$usuario);

		$response["data"]= $lista;
	

		//$log->LogInfo("Valor de la variable \$response : " . var_export ($response, true));

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se pudo obtener detalle de asistencia";
	}
/*
}
*/

echo json_encode($response);

?>