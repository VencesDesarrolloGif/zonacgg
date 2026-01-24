<?php
session_start();
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$response = array("status" => "success");
require "conexion.php";
//$log = new KLogger ( "ajaxObtenerPuntosPorEntidad.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _POST : " . var_export ($_POST, true));
$datos = array();
$idEntidad=getValueFromPost("idEntidad");
$estatusPunto=getValueFromPost("estatusPunto");
$estatusEmpleadoh=getValueFromPost("estatusEmpleadoh");
$periodo=getValueFromPost("periodo");

try{

    $sql = "SELECT idPuntoServicio,puntoServicio,idEntidadPunto,esatusPunto, idClientePunto 
    		FROM catalogopuntosservicios
    	    WHERE idEntidadPunto = '$idEntidad'
    	    AND idPeriodo=$periodo";
    
    if($estatusEmpleadoh != "0"){
        $sql.= " AND esatusPunto = '$estatusPunto'";
    }
    $sql.= " AND visiblerh=1 
    		 ORDER BY puntoServicio ASC";


    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    $response["puntoServicio"]= $datos;
    // $log->LogInfo("Valor de la variable response : " . var_export ($response, true));
}catch( Exception $e ){
    $response["status"]="error";
    $response["error"]="No se puedo obtener Punto Servicio";
}
echo json_encode($response);
?>