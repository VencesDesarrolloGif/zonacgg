<?php
session_start();
require "../conexion/conexion.php";
$response           = array();
$response["status"] = "error";
$datos              = array();
require_once("../logger/KLogger.php");
//$log = new KLogger ( "ajaxconsultaDepartamentos.log" , KLogger::DEBUG );

$lineaNegocio= $_POST['lineaNegocio'];
$categoria= $_POST['categoria'];
try {
    $sql = "SELECT idDepartamentoOrg,descripcionDepartamento
            FROM  catalogo_organigramadepartamentos
            WHERE lineaNegocio='$lineaNegocio'
            AND categoria='$categoria'
            ORDER BY idDepartamentoOrg";
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