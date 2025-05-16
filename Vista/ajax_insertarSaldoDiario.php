<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajaxbancosparasaldoinicial.log" , KLogger::DEBUG );
$listabancos=getValueFromPost("listabancos");
try
 	{       		
		//$log->LogInfo("Valor de variable a" . var_export ($listabancos, true));
		$listacuentasbancarias= $negocio -> negocio_ListaCuentasBancos();
		for($i=0;$i<count($listacuentasbancarias);$i++){
				$idbanco=$listacuentasbancarias[$i]["idBanco"];
				$idnumcuenta=$listacuentasbancarias[$i]["idCuentaBancaria"];
				$negocio -> negocio_callProcedureInserSaldoInicialDiario($idbanco,$idnumcuenta);	
		}
	}catch( Exception $e )
	{
		$response["status"]="error";
		$response["error"]="No se puedo obtener Saldos Iniciales";
	}
echo json_encode($response);
?>