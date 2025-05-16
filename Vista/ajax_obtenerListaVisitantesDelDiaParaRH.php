<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

// $log = new KLogger ( "ajaxObtenerListaParaContratacion.log" , KLogger::DEBUG );

$response = array("status" => "success");

try{

	$listaVisitantesDelDiaParaContratacion = $negocio -> negocio_traerListaVisitantesConDeptoRH();
	$response["listaVisitantesDelDiaParaContratacion"]= $listaVisitantesDelDiaParaContratacion;
	// $log -> LogInfo ("listaVisitantesDelDiaParaContratacion".var_export ($listaVisitantesDelDiaParaContratacion, true));
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista de Visitantes";
}

echo json_encode($response);

?>