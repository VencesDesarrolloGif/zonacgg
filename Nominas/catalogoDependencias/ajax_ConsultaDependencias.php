<?php
session_start();
require "../conexion/conexion.php";
$response           = array();
$response["status"] = "error";
$datos              = array();
require_once("../logger/KLogger.php");
//$log = new KLogger ( "ajaxconsultaDepartamentos.log" , KLogger::DEBUG );
try {
    $sql = "SELECT idNivelOrg, descripcionNivel
            FROM  catalogo_organigramaniveles
            ORDER BY idNivelOrg";
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