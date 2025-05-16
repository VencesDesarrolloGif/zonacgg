<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_ConsultarRegistrosPatronales.log" , KLogger::DEBUG );
$response = array("status" => "success");
$mesPost=$_POST["mes"];
$anioPost=$_POST["anio"];
$mes      = date("m");
$anio     = date("Y");
$fecha    = $anioPost . "-" . $mesPost;
$aux      = date('Y-m-d', strtotime("{$fecha} + 1 month"));
$last_day = date('Y-m-d', strtotime("{$aux} -1  day"));
if($mes==$mesPost && $anio==$anioPost){
    $last_day=date('Y-m-d');
}
$dtLast       = new DateTime($last_day);
$mesConsulta  = $dtLast->format('m');
$anioConsulta = $dtLast->format('Y');
$diasDelMes   = $dtLast->format('d');
$fechaPeriodo1 = $anioConsulta . "-" . $mesConsulta . "-01";
$fechaPeriodo2 = $last_day;
try{
	$idCliente=getValueFromPost ("idCliente");	
    $lista= $negocio -> consultaRegistrosPatronales($idCliente,$fechaPeriodo1,$fechaPeriodo2);
    $response["datos"]=$lista;


} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener consulta";
}

echo json_encode($response);
