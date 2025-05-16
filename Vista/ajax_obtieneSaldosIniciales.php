<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$datos=array();
$response = array("status" => "success");
//$log = new KLogger ( "ajaxConsultaSaldosIniciales.log" , KLogger::DEBUG );
$listabancos=getValueFromPost("listabancos");
 	try
 	{       		
//$log->LogInfo("Valor de variable a" . var_export ($listabancos, true));
	for($i=0;$i<count($listabancos);$i++)
	{
		$idbanco=$listabancos[$i]["idBanco"];
		$listaSaldosIniciales= $negocio -> negocio_cargosiniciales($idbanco);
		
			$datos[$i]["cargo"]=$listaSaldosIniciales[0]["saldoTotalPorTipoDeBancoCobranza"];
			$datos[$i]["abono"]=$listaSaldosIniciales[0]["saldoTotalPorTipoDeBancoFinanza"];
			$datos[$i]["saldo"]=$listaSaldosIniciales[0]["saldoDisponibleFin"];
		
	}	
//$log->LogInfo("Valor de variable listaSaldosIniciales" . var_export ($datos, true));

		$response["listaSaldosIniciales"]= $datos;
	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Saldos Iniciales";
	}


echo json_encode($response);

?>