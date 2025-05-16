<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "error");
// $log = new KLogger ( "ajaxObtenerPuntosByClienteEntidad.log" , KLogger::DEBUG );
if(!empty ($_POST))
{
	$response["status"]="success";
	
	$idEntidad=getValueFromPost("idEntidad");
	$idCliente=getValueFromPost("idCliente");
	$fecha1=getValueFromPost("fecha1");
	$fecha2=getValueFromPost("fecha2");
	try{		
		$puntoServicio= $negocio -> negocio_obtenerPuntosServiciosPorEntidadCliente($idEntidad,$idCliente,$fecha1,$fecha2);
		$response["puntos"]= $puntoServicio;
		// $log->LogInfo("Valor de variable de idCliente que viene de form " . var_export ($idCliente, true));
		//$log->LogInfo("Valor de variable estatusPunto substr" . var_export ($estatusPunto, true));
		// $log->LogInfo("Valor de la variable puntoServicioo punto: " . var_export ($puntoServicio, true));
	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Punto Servicio";
	}
}
echo json_encode($response);

?>