<?php
session_start();
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
// $log = new KLogger ("ajax_ConsultaDepartamentosACargo.log" , KLogger::DEBUG );
$categoria = $_POST['categoria'];
$lineaNegocio = $_POST['lineaNegocio'];
$depaSubDep = $_POST['depaSubDep'];
$nivel = $_POST['nivel'];
$nivelAbajo=$nivel+1;
try {
    $sql1 = "SELECT * 
             FROM relaciondepartamentosniveles rdna
             LEFT JOIN catalogo_organigramadepartamentos codi on (codi.idDepartamentoOrg=rdna.idDepartamento)
             WHERE idNivel='$nivelAbajo'
             AND departamentoACargo='$depaSubDep'
             AND lineaNegocio='$lineaNegocio'
             AND categoria='$categoria'";

    $res = mysqli_query($conexion, $sql1);

    while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
           $datos[] = $reg;
    }
    // $log->LogInfo("Valor de variable datos" . var_export ($datos, true));
    $response["status"] = "success";
    $response["datos"]  = $datos;
}catch(Exception $e){
       $response["message"] = "Error al iniciar sesion";
}
echo json_encode($response);