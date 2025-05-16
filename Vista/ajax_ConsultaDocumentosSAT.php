<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_ConsultaDocumentosSAT.log" , KLogger::DEBUG );
$response = array("status" => "success");
$mesPost=$_POST["mes"];
$anioPost=$_POST["anio"];
$documento=$_POST["documento"];

try{
    $lista= $negocio -> consultaDocumentoSAT($anioPost,$mesPost,$documento);   
    $response["datos"]=$lista;
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se pudo obtener consulta";
}

echo json_encode($response);
