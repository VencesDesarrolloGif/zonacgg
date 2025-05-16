<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

//$log = new KLogger ( "ajaxListaSupervisoresOperativos.log" , KLogger::DEBUG );

$response = array("status" => "success");

try{


	$listaSupervisoresOperativos = $negocio -> negocio_obtenerSupervisoresOperativoselectronica();
	$response["listaSupervisoresOperativos"]= $listaSupervisoresOperativos;
	//$log->LogInfo("Valor de la variable \$listaSupervisoresOperativos: " . var_export ($response, true));
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista se supervisores operativos";
}

echo json_encode($response);

?>