<?php
session_start();
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ("ajax_ConsultaDepartamento.log" , KLogger::DEBUG );
$categoria=$_POST['categoria'];
$lineaNegocio=$_POST['lineaNegocio'];
try {
    $sql = "SELECT idDepartamentoOrg,descripcionDepartamento
            FROM  catalogo_OrganigramaDepartamentos
            WHERE lineaNegocio='$lineaNegocio'
            AND categoria='$categoria'
            ORDER BY descripcionDepartamento";
    $res = mysqli_query($conexion, $sql);

    while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
           $datos[] = $reg;
    }
    //$log->LogInfo("Valor de variable datos" . var_export ($datos, true));
    $response["status"] = "success";
    $response["datos"]  = $datos;
}catch(Exception $e){
       $response["message"] = "Error al iniciar sesion";
}
echo json_encode($response);