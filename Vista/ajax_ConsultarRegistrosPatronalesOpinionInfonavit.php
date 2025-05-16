<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_ConsultarRegistrosPatronales.log" , KLogger::DEBUG );
$response = array("status" => "success");
$mesPost=$_POST["mes"];
$anioPost=$_POST["anio"];

try{
    $lista= $negocio -> consultaRegistrosPatronalesInfonavit($mesPost,$anioPost);
    $response["datos"]=$lista;
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener consulta";
}

echo json_encode($response);
