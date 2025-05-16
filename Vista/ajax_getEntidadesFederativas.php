<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
//$log = new KLogger ( "aaaaaaaaaaaaaa.log" , KLogger::DEBUG );
$negocio = new Negocio();
 
verificarInicioSesion ($negocio);


$response = array("status" => "success");

try{
	$rolusuario= $_SESSION ["userLog"]['rol'];

	if($rolusuario=="Lider Unidad"){
		$listaEntidades= $negocio -> negocio_obtenerListaEntidadesFeferativasLU($_SESSION ["userLog"]);
		$response["listaEntidades"]= $listaEntidades;
	}else{
		$listaEntidades= $negocio -> negocio_obtenerListaEntidadesFeferativas();
		$response["listaEntidades"]= $listaEntidades;
	}
	//$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista de Clientes";
}

echo json_encode($response);

?>