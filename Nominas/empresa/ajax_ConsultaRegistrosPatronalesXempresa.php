<?php
session_start();
require "../conexion/conexion.php";
$response           = array();
$response["status"] = "error";
$datos              = array();
require_once("../logger/KLogger.php");
$idempresa =$_POST['idempresa'];
//$log = new KLogger ( "ajax_ConsultaRegistrosPatronalesXempresa.log" , KLogger::DEBUG );
try {
    $sql = "SELECT distinct(crp.idcatalogoRegistrosPatronales)
            FROM empresa em
            LEFT JOIN sucursal suc on (em.idEmpresa=suc.idEmpresaSuc)
            LEFT JOIN catalogoregistrospatronales crp on(crp.idcatalogoRegistrosPatronales=suc.IdRegistroPatronal)
            WHERE idEmpresa='$idempresa'";

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