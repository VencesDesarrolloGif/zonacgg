<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajaxReporteGeneral.log" , KLogger::DEBUG );

$response = array("status" => "success");

try{

	$listaEmpleados= $negocio -> consultaGeneral();
	$response["listaEmpleados"]= $listaEmpleados;
	// $log->LogInfo("Valor de la variable \$listaEmpleados: " . var_export ($response, true));

} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener reporte";
}

echo json_encode($response);

?>