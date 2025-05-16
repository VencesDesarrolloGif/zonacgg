<?php
session_start();
require_once("../libs/logger/KLogger.php");
require "conexion.php";
// $log = new KLogger("ajax_ConsultaTarjetaPatronalXCliente.log", KLogger::DEBUG);
$response = array();
$datos = array();
$response["status"]= "error";
$anio = $_POST["anioDoc"];
$mes  = $_POST["mesDoc"];
$registroPatronal = $_POST["regDoc"];
$fechaInicio = $anio."-".$mes."-01";

if ($mes=='01'){
    $fechaFin  =$anio."-".$mes."-31";
}
if ($mes=='02'){
    $fechaFin  =$anio."-".$mes."-28";
}
if ($mes=='03'){
    $fechaFin  =$anio."-".$mes."-31";
}
if ($mes=='04'){
    $fechaFin  =$anio."-".$mes."-30";
}
if ($mes=='05'){
    $fechaFin  =$anio."-".$mes."-31";
}
if ($mes=='06'){
    $fechaFin  =$anio."-".$mes."-30";
}
if ($mes=='07'){
    $fechaFin  =$anio."-".$mes."-31";
}
if ($mes=='08'){
    $fechaFin  =$anio."-".$mes."-31";
}
if ($mes=='09'){
    $fechaFin  =$anio."-".$mes."-30";
}
if ($mes=='10'){
    $fechaFin  =$anio."-".$mes."-31";
}
if ($mes=='11'){
    $fechaFin  =$anio."-".$mes."-30";
}
if ($mes=='12'){
    $fechaFin  =$anio."-".$mes."-31";
}

// $log->LogInfo("Valor de la variable fechaConsultada: " . var_export ($fechaConsultada, true));
try {
    $sql = "SELECT nombreDocumento 
            FROM catalogotarjetaspatronales
            WHERE ((fechaExpedicion <= CAST('$fechaInicio' AS DATE) AND fechaFinVigencia >= CAST('$fechaInicio' AS DATE))
            OR (fechaExpedicion >= CAST('$fechaInicio' AS DATE) AND fechaExpedicion <= CAST(' $fechaFin' AS DATE) AND fechaFinVigencia >= CAST('$fechaInicio' AS DATE)))
            AND registroPatronalTarjeta='$registroPatronal'
            ORDER BY idTarjetasPatronales desc
            LIMIT 1";      
// $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));

    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
        $datos[] = $reg;
    }

    $response["status"] = "success";
    $response["datos"]  = $datos;
}catch (Exception $e) {
    $response["mensaje"]= "Error al iniciar sesion";}
echo json_encode($response);
