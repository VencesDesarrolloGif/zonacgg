<?php
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
// $log = new KLogger ( "ajax_ConsultaPuestosAsignados.log" , KLogger::DEBUG );
$categoriaPuesto= $_POST['categoria'];
$lineaNegocio   = $_POST['lineaNegocio'];
$nivel = $_POST['nivel'];

try {
    $sql = "SELECT * 
            FROM catalogo_organigramadepartamentos cod
            LEFT JOIN relacionDepartamentosNiveles rdn on cod.idDepartamentoOrg=rdn.idDepartamento
            WHERE lineaNegocio='$lineaNegocio'
            AND categoria='$categoriaPuesto'
            AND idNivel='$nivel'";
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