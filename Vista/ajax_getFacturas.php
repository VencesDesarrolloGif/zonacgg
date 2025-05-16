<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajaxGetFacturas.log" , KLogger::DEBUG );
try{

	$facturas = $negocio ->  obtenerFacturas();
	//$log->LogInfo("Valor de la variable $facturas: " . var_export ($facturas, true));
	for($i = 0; $i < count($facturas); $i++){

		$idFactura = $facturas[$i] ["idFactura"];
		$pagada = $facturas[$i] ["facturaPagada"];
		$entregada = $facturas[$i] ["mercanciaEntregada"];
		$facturas[$i]["accion_ver_detalle"] = "<a href='javascript:mostrarModalDetalle(\"" . $idFactura . "\",\"".$pagada."\",\"".$entregada."\");'>Ver Detalle</a>";
	}
	$response["data"]= $facturas;
} 
catch( Exception $e )		
{
	$response["status"]="error";
	$response["error"]="No se pudieron obtener facturas";	
}

echo json_encode($response);

?>


