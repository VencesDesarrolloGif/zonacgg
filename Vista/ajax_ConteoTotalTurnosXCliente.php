<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$usuario=$_SESSION;
//$log = new KLogger ( "ajax_generarResumenAsistencia.log" , KLogger::DEBUG );
$response = array("status" => "success");

try{
    $accion=getValueFromPost ("accion");
    $idcliente=getValueFromPost ("idcliente");
    $fechadia = getValueFromPost ("fechadia"); 
    if($accion==1){
    $listaincidenciasdiabycliente= $negocio -> obtenerIncidenciasXdiaXcliente($idcliente,$fechadia,$usuario);
    $response["datos"]=$listaincidenciasdiabycliente;
}else if($accion==2 || $accion==3){
         $listaincidenciaturnosdia= $negocio -> obtenerIncidenciasdeTurnosDia($idcliente,$fechadia,$accion,$usuario);
         $response["turnosdianoche"]=$listaincidenciaturnosdia;
}
   // $log->LogInfo("Valor de la variable \$lista: " . var_export ($response, true));
} 
catch( Exception $e ){
    $response["status"]="error";
    $response["error"]="No se puedo obtener consulta";
}

echo json_encode($response);