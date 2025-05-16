<?php
session_start();
require_once("../libs/logger/KLogger.php"); 
require "conexion.php";
$log = new KLogger("ajax_consultaRPxPS.log", KLogger::DEBUG);
$response = array();
$response["status"]= "error";

$rpActual = $_POST["rpActual"]; 
$nuevoPS = $_POST["nuevoPS"]; 
$registroPatronalPS= array();

try {

    $sql = "SELECT s.IdRegistroPatronal
            FROM catalogopuntosservicios cps
            LEFT JOIN asentamientos a ON a.municipioAsentamiento=cps.MunicipioPuntoS
            LEFT JOIN sucursal s ON s.IdSuc=a.idRegPatAsignado
            WHERE idPuntoServicio='$nuevoPS'
            LIMIT 1";

    $res = mysqli_query($conexion, $sql);
    while($reg = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
          $registroPatronalPS[]=$reg;
    }
    $IdRegistroPatronal = $registroPatronalPS[0]["IdRegistroPatronal"];

    if($IdRegistroPatronal!=$rpActual){
        $response["accion"] = "1";
        $response["rp"] = $IdRegistroPatronal;
    }else{
        $response["accion"] = "0";  
        $response["rp"] = $rpActual;  
    }
    $response["status"] = "success";
    $log->LogInfo("Valor de la variable response: " . var_export ($response, true));                                                                      
}catch(Exception $e) {
    $response["mensaje"]= "Error al Consultar Estatus Del Empleado";
}
echo json_encode($response);
