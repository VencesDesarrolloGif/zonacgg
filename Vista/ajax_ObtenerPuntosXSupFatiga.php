<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio); 

//$log = new KLogger ( "ajaxListaSupervisoresOperativos.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable POST: " . var_export ($_POST, true));
$response = array("status" => "success");
$idClientePunto=getValueFromPost ("idClientePunto");
$rangoFecha1=getValueFromPost ("rangoFecha1");
$rangoFecha2=getValueFromPost ("rangoFecha2");
try{


	$listaSupervisoresOperativos = $negocio -> negocio_obtenerSupervisoresXPuntoFati($idClientePunto,$rangoFecha1,$rangoFecha2);
	$response["PuntosxSupFat"]= $listaSupervisoresOperativos;
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista se supervisores operativos";
}

echo json_encode($response);

?>