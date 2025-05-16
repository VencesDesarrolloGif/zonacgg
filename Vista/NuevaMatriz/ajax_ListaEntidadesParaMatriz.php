<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_ConsultaPeticionesTurnosCapacitacion.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
try {
    $sql = "SELECT IdEntidadAsignada as idEntidadFederativa,nombreEntidadAsignada as nombreEntidadFederativa, EstatusEntidadesMatriz as estatus FROM matricesEntidades
            group by IdEntidadAsignada desc
            union
            SELECT idEntidadFederativa,nombreEntidadFederativa, EstatusEntidadesMatriz as estatus FROM entidadesfederativas ef
            left join matricesEntidades mae ON (ef.idEntidadFederativa = mae.IdEntidadAsignada )
            where mae.IdMatrizEntidad is null
            order by idEntidadFederativa ";      
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));

    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al Obtener Entidades Para Matriz";}
echo json_encode($response);
