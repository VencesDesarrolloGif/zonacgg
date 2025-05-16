<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_ListaEntidadesParaAsignarALaMatrizEdicion.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
try {
    $sql = "SELECT * FROM entidadesfederativas efe
            left join matricesEntidades mae ON (efe.idEntidadFederativa = mae.IdEntidadAsignada and mae.EstatusEntidadesMatriz!='0')
            where (IdEntidadAsignada is null or EstatusEntidadesMatriz !='1')";      
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));

    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al Obtener Entidades Para Asigacion A La Matriz";}
echo json_encode($response);
