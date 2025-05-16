<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

try{

	$inicio=getValueFromPost ("inicio");
	$registrosPorPagina=getValueFromPost("visitantesPorPagina");

	$listaVisitantesDelDia = $negocio -> negocio_obtenerListaDeVisitantesDelDia($inicio,$registrosPorPagina);
	$response["listaVisitantesDelDia"]= $listaVisitantesDelDia;

} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista de Visitantes";
}

echo json_encode($response);

?>