<?php
session_start();
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
$registroPatronalActual=$_POST['registroPatronalActual'];
//$log = new KLogger ( "ajax_ConsultaTarjetasPatronales.log" , KLogger::DEBUG );
try {
    $sql = "SELECT idTarjetasPatronales,registroPatronalTarjeta,fechaExpedicion,fechaFinVigencia,nombreDocumento 
            FROM  catalogoTarjetasPatronales
            WHERE estatusEliminadoTarjetasPatronales='0'
            AND registroPatronalTarjeta='$registroPatronalActual'";
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
    	 }

//$log->LogInfo("Valor de variable datos" . var_export ($datos, true));

    $response["status"] = "success";
    $response["datos"]  = $datos;

 }catch (Exception $e) {
    $response["message"] = "Error al iniciar sesion";
	}
echo json_encode($response);