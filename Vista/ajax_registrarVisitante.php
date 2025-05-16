<?php

session_start();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

$response = array ();

verificarInicioSesion($negocio);

if(!empty($_POST))
{
	//$log = new KLogger ( "ajax.log" , KLogger::DEBUG );

	$visitante = array (
		"visitanteApPaterno" =>strtoupper(getValueFromPost("vApellidoPaterno")), 
		"visitanteApMaterno" => strtoupper(getValueFromPost("vApellidoMaterno")),
		"visitanteNombre" => strtoupper(getValueFromPost("vNombre")),
		"visitanteIdDepto" => getValueFromPost("areaVisita"),
		"visitanteIdAsunto" => getValueFromPost("asuntoVisita"),
		"visitanteIdIdentificacion" => getValueFromPost("identificacion"),
		"visitanteEmpresa" => getValueFromPost("vEmpresa"),
		"visitanteIdEstatus" => 1

		);

		//$log -> LogInfo (var_export ($visitante, true));
	try
	{
		$negocio -> registrarVisitante($visitante);

		$response["status"] = "success";
		$response ["message"] = "Se registro al visitante Exitosamente";
	}
	catch(Exception $e)
	{
		$response["status"] = "error";
		$response["message"] = "Error al registrar al Visitante:" .$e -> getMessage();
	}
}
else
{
	$response["status"] = "error";
	$response["message"] = "No se Proporcionaron datos";
}

echo json_encode($response);

?>