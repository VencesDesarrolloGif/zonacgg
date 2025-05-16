<?php
// session_start();
    require "../conexion.php";
    require_once("../../libs/logger/KLogger.php");
    $response           = array();
    $response["status"] = "error";
    $datos              = array();
    // $log = new KLogger ( "ajax_obtenerFolioPresPostulate.log" , KLogger::DEBUG );
    //$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
    try {
        $sql = "SELECT  LPAD(IF(MAX( folioPreseleccion ) IS NULL , 1, MAX( folioPreseleccion ) + 1 ), 7, 0)  AS 'folioPres',ifnull(max(idPreseleccion),0)+1 as idPreContrato from empleados_preseleccion";
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
        $response["status"]= "success";
        $response["folioPre"]= $datos;
        // $log->LogInfo("Valor de la variable response " . var_export ($response, true));
    }catch (Exception $e) {
        $response["mensaje"] = "Error al Obtener Matrices";
    }
echo json_encode($response);
