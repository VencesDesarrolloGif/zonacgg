<?php
session_start();

require_once("../Negocio/Negocio.class.php"); 
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();
 
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_getEmpleadosEstatusOperaciones.log" , KLogger::DEBUG );
$usuario=$_SESSION['userLog'];
$FechaDiaActual = date("Y-m-d");
$response = array("status" => "success");

//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable usuario: " . var_export ($usuario, true));

if (!empty ($_POST))
{
 
	try{

	$estatusEmpleadoOperaciones=getValueFromPost("estatusEmpleadoOperaciones");
	$lista= $negocio -> getEmpleadosEstatusOperaciones($estatusEmpleadoOperaciones,$usuario); 

	$fecharango= $negocio -> obtenerfecha($FechaDiaActual);
	$FechaInicio = $fecharango[0]["FechaInicio"];
    $FechaFinal = $fecharango[0]["FechaFinal"];
	$lista1= $negocio -> getEmpleadosEstatusOperacionesConCondiciones($usuario,$FechaInicio,$FechaFinal);

	$result = array_merge($lista, $lista1);

	$response["lista"]= $result;


	
//$log->LogInfo("Valor de la variable lista: " . var_export ($lista, true));
//$log->LogInfo("Valor de la variable lista1: " . var_export ($lista1, true));

	} catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista de solicitudes de baja";
	}

}else{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}

echo json_encode($response);

?>