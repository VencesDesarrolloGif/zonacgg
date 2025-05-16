<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

try{


	$listaPersonalActivo = $negocio ->  negocio_traerListaPersonalActivo();

	$response["listaPersonalActivo"]= $listaPersonalActivo;

} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista de personal Activo";
}

echo json_encode($response);

?>