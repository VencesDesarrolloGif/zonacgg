<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajaxListaClientes.log" , KLogger::DEBUG );

$response = array("status" => "success");
$numeroEmpleado=$_SESSION ["userLog"]["empleadoId"];
$fecha1=getValueFromPost("fecha1");

try{
	$empleadoidd = explode("-", $numeroEmpleado);

	$empleadoEntidad=$empleadoidd[0];
    $empleadoConsecutivo=$empleadoidd[1];
    $empleadoCategoria=$empleadoidd[2];

$idGuardia = array (
    "entidadEmpleado" =>substr($empleadoEntidad),
    "consecutivoEmpleado" =>substr($empleadoConsecutivo),
    "tipoEmpleado" =>substr($empleadoCategoria),
    );

	$ubicaciones= $negocio -> getUbicacionesGuardiaByFecha($fecha1,$idGuardia);
	$response["ubicaciones"]= $ubicaciones;
	//$log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($response, true));

} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener ubicaciones";
}

echo json_encode($response);
//ajax_getUbicacionesGuardiaByFecha.php
?>