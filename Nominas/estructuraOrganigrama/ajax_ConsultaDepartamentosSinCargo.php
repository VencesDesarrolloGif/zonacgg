<?php
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
// $log = new KLogger ( "ajax_ConsultaDepartamentosACargo.log" , KLogger::DEBUG );
$categoria = $_POST['categoria'];
$lineaNegocio = $_POST['lineaNegocio'];
$depaSubDep = $_POST['depaSubDep'];
$nivel = $_POST['nivel'];
$nivelAbajo=$nivel+1;

try {
    $sql = "SELECT * 
            FROM relaciondepartamentosniveles rdn
            LEFT JOIN catalogo_organigramadepartamentos cod on (cod.idDepartamentoOrg=rdn.idDepartamento)
            WHERE idNivel='$nivelAbajo'
            AND departamentoACargo='0'
            AND lineaNegocio='$lineaNegocio'
            AND categoria='$categoria'";

    $res = mysqli_query($conexion, $sql);
    while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
           $datos[] = $reg;
    }
    // $log->LogInfo("Valor de variable sql" . var_export ($sql, true));
    // $log->LogInfo("Valor de variable datos" . var_export ($datos, true));
    $response["status"] = "success";
    $response["datos"]  = $datos;
}catch(Exception $e){
       $response["message"] = "Error al iniciar sesion";
}
echo json_encode($response);