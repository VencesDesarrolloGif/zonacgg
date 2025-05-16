<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajaxConsultaEmpleadosBajaFechaCaptura.log" , KLogger::DEBUG );

$fechaCaptura=getValueFromPost("fechaCaptura");

//$log->LogInfo("Valor de la variable \$fechaCaptura: " . var_export ($fechaCaptura, true));

$dia=substr($fechaCaptura, 8,2);
$mes=substr($fechaCaptura, 5,2);
$anio=substr($fechaCaptura, 0,4);

//$log->LogInfo("Valor de la variable \$anio: " . var_export ($anio, true));
//$log->LogInfo("Valor de la variable \$mes: " . var_export ($mes, true));
//$log->LogInfo("Valor de la variable \$dia: " . var_export ($dia, true));

$response = array("status" => "success");

try{

	$listaEmpleados= $negocio -> selectBajasEmpleadosPorFechaCaptura($dia, $mes, $anio);
	$response["listaEmpleados"]= $listaEmpleados;
	//$log->LogInfo("Valor de la variable \$listaEmpleados: " . var_export ($response, true));

} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener consulta";
}

echo json_encode($response);

?>