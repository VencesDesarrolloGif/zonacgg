<?php
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php"); 
$negocio = new Negocio ();
verificarInicioSesion ($negocio);  
//$log = new KLogger ( "ajax_getDetalleRequisicionesByPuntoServicioIdFatiga.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable puntoServicioId: " . var_export ($_POST, true));
$response = array("status" => "success");
try{
	$puntoServicioId=getValueFromPost ("idPuntoServicio");
    $fechaInicial = getValueFromPost ("rangoFecha1");
    $fechaFinal = getValueFromPost ("rangoFecha2");
    $lista= $negocio -> getDetalleRequisicionesByPuntoServicioIdFATIGA($puntoServicioId,$fechaInicial,$fechaFinal,1);
	//$log->LogInfo("Valor de la variable lista: " . var_export ($lista, true));
	$response["lista"]= $lista;
	//$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener consulta";
}

echo json_encode($response);

