<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");


if(!empty ($_POST))
{

	
		//$log = new KLogger ( "ajaxObtenerMotivosBajaPorTipoBaja.log" , KLogger::DEBUG );
		$idTipoBaja=getValueFromPost("idTipoBaja");



	try{
		

		$motivosBaja= $negocio -> obtenerCatalogoMotivosBajaPorTipoBaja($idTipoBaja);
		$response["motivosBaja"]= $motivosBaja;

		//$log->LogInfo("Valor de variable de idEntidad que viene de form" . var_export ($idTipoBaja, true));


		//$log->LogInfo("Valor de la variable \$response punto: " . var_export ($response, true));

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Motivos Baja";
	}
}

echo json_encode($response);

?>