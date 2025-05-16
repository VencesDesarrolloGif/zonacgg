<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
$datos1              = array();
// $log = new KLogger ( "ajax_obtenerEntidadesPorRegionParaAsignar.log" , KLogger::DEBUG );
try {
    $SelectRegiones = $_POST["SelectRegiones"];
    $SelectLineaNegocioRegion  = $_POST["SelectLineaNegocioRegion"];
    $sql = "SELECT idEntidadI from index_regiones 
            where  idLineaNegI='$SelectLineaNegocioRegion'";      
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    $sql1 ="SELECT * FROM entidadesfederativas";
    $largo = count($datos)-1;
    for ($i=0; $i < count($datos); $i++) { 
        $entidad = $datos[$i]["idEntidadI"];
        // $log->LogInfo("Valor de la variable entidad " . var_export ($entidad, true));
        if($i==0){
            $sql1.=" where(";
        }
        $sql1.="idEntidadFederativa != '$entidad'";
        if($i == $largo){
            $sql1.=")";
        }else{
            $sql1.=" and ";
        }
    }
    // $log->LogInfo("Valor de la variable sql1 " . var_export ($sql1, true));
                  
    $res1 = mysqli_query($conexion, $sql1);
    while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
        $datos1[] = $reg1;
    }
    $response["status"]= "success";
    $response["datos"] = $datos1;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
